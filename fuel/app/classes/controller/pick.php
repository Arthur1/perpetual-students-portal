<?php
class Controller_Pick extends Controller_Template
{
	public function action_index()
	{
		$this->template->title = '初手ピックシミュレーター';
		$this->template->contents = View::forge('pick/index');
		if (Input::post('submit'))
		{
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください。';
				return;
			}
			$major_improvements = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'M001', 'M002', 'M003', 'M004', 'M005', 'M006', 'M007', 'M008', 'M009', 'M010', 'M011', 'M012', 'M013', 'M014'];
			$occupations_record = DB::select('occupation_id')
								->from('cards_occupations')
								->execute()->as_array();
			$improvements_record = DB::select('improvement_id')
								->from('cards_improvements')
								->where('improvement_id', 'not in', $major_improvements)
								->and_where('improvement_id', 'NOT LIKE', 'M%')
								->execute()->as_array();
			$occupations_key = array_rand($occupations_record, 7);
			$improvements_key = array_rand($improvements_record, 7);
			$occupations = [];
			$improvements = [];
			foreach ($occupations_key as $key)
			{
				$occupations[] = $occupations_record[$key]['occupation_id'];
			}
			foreach ($improvements_key as $key)
			{
				$improvements[] = $improvements_record[$key]['improvement_id'];
			}
			$params_str = implode('|', $occupations);
			$params_str .= '|';
			$params_str .= implode('|', $improvements);
			$params_compressed = gzdeflate($params_str);
			Response::redirect('pick/vote?p='.urlencode($params_compressed).'&o='.random_int(1, 5));
		}
	}

	public function action_vote()
	{
		Asset::js(['pick/vote.js'], [], 'add_js');
		$this->template->title = '初手ピックシミュレーター';
		$this->template->contents = View::forge('pick/vote');
		$this->template->contents->deck_list = [
			'E' => 'Eデッキ(基本セット)',
			'I' => 'Iデッキ(基本セット)',
			'K' => 'Kデッキ(基本セット)',
			'G' => 'Gデッキ',
			'FL' => 'FLデッキ',
			'WA' => 'WAデッキ',
			'C' => 'Čデッキ',
			'P' => 'πデッキ',
			'O' => 'Öデッキ',
			'BI' => 'BIデッキ',
			'NL' => 'NLデッキ',
			'Z' => 'Zデッキ',
			'FR' => 'FRデッキ',
			'alpha' => 'αデッキ(WMデッキ)',
			'beta' => 'βデッキ(WMデッキ)',
			'gamma' => 'γデッキ(WMデッキ)',
			'epsilon' => 'εデッキ(WMデッキ)',
			'delta' => 'δデッキ(WMデッキ)',
			'ME' => 'Eデッキ(泥沼からの出発)',
			'MF' => 'Fデッキ(泥沼からの出発)',
		];
		$params_compressed = Input::get('p');
		$params_str = gzinflate($params_compressed);
		$params = explode('|', $params_str);
		if (count($params) !== 14) throw new HttpNotFoundException;
		$this->template->description = '拡張入りアグリコラのピックシミュレーターです';
		$this->template->ogp_image_large2 = 'pick/image.png?p='.urlencode($params_compressed).'&o='.Input::get('o');
		$occupations = [];
		$improvements = [];
		for ($i = 0; $i < 7; $i++)
		{
			$occupations[] = $params[$i];
		}
		for ($i = 7; $i < 14; $i++)
		{
			$improvements[] = $params[$i];
		}
		$this->template->contents->occupations = $occupations;
		$this->template->contents->improvements = $improvements;
		$occupations_data = DB::select()
								->from('cards_occupations')
								->where('occupation_id', 'in', $occupations)
								->execute()->as_array();
		$improvements_data = DB::select()
								->from('cards_improvements')
								->where('improvement_id', 'in', $improvements)
								->execute()->as_array();
		$this->template->contents->occupations_data = $occupations_data;
		$this->template->contents->improvements_data = $improvements_data;
		if (Input::post('submit'))
		{
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください。';
				return;
			}
			$val = Validation::forge();
			$val->add('occupation', '職業')
				->add_rule('required')
				->add_rule('match_collection', $occupations);
			$val->add('improvement', '小さい進歩')
				->add_rule('required')
				->add_rule('match_collection', $improvements);
			if (! $val->run())
			{
				$this->template->contents->error = $val->error();
				return;
			}
			$occupations_query = DB::insert('pick_occupations')
									->columns(['occupation_id', 'is_picked']);
			$improvements_query = DB::insert('pick_improvements')
									->columns(['improvement_id', 'is_picked']);
			foreach ($occupations as $occupation)
			{
				$occupations_query->values([$occupation, $occupation === Input::post('occupation')]);
			}
			foreach ($improvements as $improvement)
			{
				$improvements_query->values([$improvement, $improvement === Input::post('improvement')]);
			}
			try
			{
				$occupations_query->execute();
				$improvements_query->execute();
				Session::set_flash('message', '投票完了しました。ご協力ありがとうございました。');
				Response::redirect('pick/vote?p='.urlencode($params_compressed).'&o='.Input::get('o'));
			}
			catch (\DatabaseException $e)
			{
				$this->template->contents->error = 'データベースエラーです。時間をおいて再度送信してください。';
				return;
			}
		}

	}

	public function action_image()
	{
		$params_compressed = Input::get('p');
		$params_str = gzinflate($params_compressed);
		$params = explode('|', $params_str);
		if (count($params) !== 14) throw new HttpNotFoundException;
		$occupations = [];
		$improvements = [];
		for ($i = 0; $i < 7; $i++)
		{
			$occupations[] = $params[$i];
		}
		for ($i = 7; $i < 14; $i++)
		{
			$improvements[] = $params[$i];
		}
		$occupations_data = DB::select()
								->from('cards_occupations')
								->where('occupation_id', 'in', $occupations)
								->execute()->as_array();
		$improvements_data = DB::select()
								->from('cards_improvements')
								->where('improvement_id', 'in', $improvements)
								->execute()->as_array();
		$img = imagecreatefrompng(DOCROOT.'assets/img/pick_bg.png');
		$color = imagecolorallocate($img, 10, 10, 10);
		$font = DOCROOT.'assets/fonts/noto.ttf';
		for ($i = 0; $i < 7; $i++)
		{
			$occupation_text = '［'.$occupations_data[$i]['occupation_id'].'］'.$occupations_data[$i]['japanese_name'];
			$improvement_text = '［'.$improvements_data[$i]['improvement_id'].'］'.$improvements_data[$i]['japanese_name'];
			imagettftext($img, 24, 0, 56, 270 + 44 * $i, $color, $font, $occupation_text);
			imagettftext($img, 24, 0, 558, 270 + 44 * $i, $color, $font, $improvement_text);
		}
		imagettftext($img, 24, 0, 309, 155, $color, $font, '全混ぜ');
		imagettftext($img, 24, 0, 643, 155, $color, $font, Input::get('o').'番手/5人');
		$this->template = null;
		$this->response = new Response();
		$this->response->set_header('Content-Type', 'image/png');
		imagepng($img);
		imagedestroy($img);
		return $this->response;
	}
}