<?php
class Controller_Result extends Controller_Template
{
	private $score_fields = [
		'fields',
		'pastures',
		'grain',
		'vegetable',
		'sheep',
		'boars',
		'cattle',
		'horses',
		'unused_spaces',
		'stables',
		'houses',
		'family',
		'begging',
		'card_points',
		'bonus_points',
		'total_score',
		'rank',
		'comments',
	];
	private $card_fields = [
		'occupations',
		'minor_improvements',
		'major_improvements',
	];
	private $additional_fields = [
		'game_id',
		'player_order',
		'image_path',
	];

	public function action_article($game_id)
	{
		$this->template->contents = View::forge('result/article');
		Asset::js(['result/article.js'], [], 'add_js');
		$overview_query = DB::select()
							->from('result_overview')
							->where('game_id', '=', $game_id)
							->limit(1);
		try
		{
			$overview_data = $overview_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			throw new HttpNotFoundException;
		}
		// マッチするデータが無かった場合
		if ($overview_data === [])
		{
			throw new HttpNotFoundException;
		}
		$this->template->title = date('Y/m/d H:i', $game_id).'の結果';
		$players_query = DB::select()
						->from('result_players')
						->where('game_id', '=', $game_id)
						->order_by('player_order', 'asc')
						->join('users_profile', 'inner')
						->on('result_players.player_id', '=', 'users_profile.user_id');
		$score_query = DB::select()
					->from('result_score')
					->where('game_id', '=', $game_id)
					->order_by('player_order', 'asc');
		try
		{
			$players_data = $players_query->execute()->as_array();
			$score_data = $score_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			throw new HttpNotFoundException;
		}
		$occupations_query = DB::select()
								->from('result_occupations')
								->where('game_id', '=', $game_id)
								->join('cards_occupations', 'inner')
								->on('result_occupations.occupation_id', '=', 'cards_occupations.occupation_id');
		$minor_improvements_query = DB::select()
										->from('result_minor_improvements')
										->where('game_id', '=', $game_id)
										->join('cards_improvements', 'inner')
										->on('result_minor_improvements.improvement_id', '=', 'cards_improvements.improvement_id');
		$major_improvements_query = DB::select()
										->from('result_major_improvements')
										->where('game_id', '=', $game_id)
										->join('cards_improvements', 'inner')
										->on('result_major_improvements.improvement_id', '=', 'cards_improvements.improvement_id');
		try
		{
			$occupations_data = $occupations_query->execute()->as_array();
			$minor_improvements_data = $minor_improvements_query->execute()->as_array();
			$major_improvements_data = $major_improvements_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			throw new HttpNotFoundException;
		}
		$this->template->contents->overview_data = $overview_data[0];
		$this->template->contents->players_data = $players_data;
		$this->template->contents->score_data = array_column($score_data, null, 'player_order');
		$this->template->contents->occupations_data = $occupations_data;
		$this->template->contents->minor_improvements_data = $minor_improvements_data;
		$this->template->contents->major_improvements_data = $major_improvements_data;
	}

	public function action_edit($game_id, $player_order)
	{
		Authplus::check_and_redirect([1]);
		$this->template->title = 'スコア編集ページ';
		$this->template->contents = View::forge('result/edit');
		Asset::js(['result/edit.js'], [], 'add_js');
		$query = DB::select()
					->from('result_players')
					->where('game_id', '=', $game_id)
					->and_where('player_order', '=', $player_order)
					->and_where('is_edited', '=', false);
		try
		{
			$data = $query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		if ($data === [])
		{
			throw new HttpNotFoundException;
		}
		$this->template->contents->data = $data[0];
		if (Input::post('submit'))
		{
			foreach ($this->score_fields as $field)
			{
				Session::set_flash($field, Input::post($field));
			}
			foreach ($this->card_fields as $field)
			{
				Session::set_flash($field, Input::post($field));
			}
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが再度送信してください。';
				return;
			}
			$val = $this->generate_val();
			if (! $val->run())
			{
				$this->template->contents->error = $val->error();
				return;
			}
			Debug::dump(Input::file(('image')));
			if (Input::file('image')['name'] !== '')
			{
				Upload::process([
					'path' => DOCROOT.'assets/img/upload/result',
					'ext_whitelist' => ['jpg', 'jpeg', 'png', 'gif'],
					'new_name' => $game_id.'_'.$player_order,
					'auto_rename' => false,
					'overwrite' => true,
					'max_size' => 5 * 1024 * 1024,
					'create_path' => true,
				]);
				if (! Upload::is_valid())
				{
					$errors = Upload::get_errors('image')['errors'];
					$this->template->contents->error = [];
					foreach ($errors as $error)
					{
						$this->template->contents->error[] = $error['message'];
					}
					return;
				}
				Upload::save();
				Session::set_flash('image_path', Upload::get_files('image')['saved_as']);
			}
			Session::set_flash('game_id', $game_id);
			Session::set_flash('player_order', $player_order);
			Response::redirect('result/confirm');
		}
	}

	public function action_confirm()
	{
		Authplus::check_and_redirect([1]);
		$this->template->title = '確認ページ';
		$this->template->contents = View::forge('result/confirm');
		foreach ($this->score_fields as $field)
		{
			$score_data[$field] = Session::get_flash($field);
			Session::keep_flash($field);
		}
		foreach ($this->card_fields as $field)
		{
			$card_data[$field] = Session::get_flash($field);
			$card_data[$field] = array_filter($card_data[$field], 'strlen');
			$card_data[$field] = array_values($card_data[$field]);
			Session::set_flash($field, $card_data[$field]);
			Session::keep_flash($field);
		}
		foreach ($this->additional_fields as $field)
		{
			$score_data[$field] = Session::get_flash($field);
			Session::keep_flash($field);
		}
		if ($score_data['grain'] === null)
		{
			throw new HttpNotFoundException;
		}
		$this->template->contents->score_data = $score_data;
		$this->template->contents->card_data = $card_data;
		if (Input::post('return'))
		{
			Response::redirect('result/edit/'.$score_data['game_id'].'/'.$score_data['player_order']);
		}
		if (Input::post('submit'))
		{
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください。';
				return;
			}
			$score_query = DB::insert('result_score')->set($score_data);
			$occupations_query = DB::insert('result_occupations')
									->columns([
										'game_id',
										'player_order',
										'occupation_id',
									]);
			foreach ($card_data['occupations'] as $occupation_id)
			{
				$occupations_query->values([
					$score_data['game_id'],
					$score_data['player_order'],
					$occupation_id,
				]);
			}
			$minor_improvements_query = DB::insert('result_minor_improvements')
									->columns([
										'game_id',
										'player_order',
										'improvement_id',
									]);
			foreach ($card_data['minor_improvements'] as $improvement_id)
			{
				$minor_improvements_query->values([
					$score_data['game_id'],
					$score_data['player_order'],
					$improvement_id,
				]);
			}
			$major_improvements_query = DB::insert('result_major_improvements')
									->columns([
										'game_id',
										'player_order',
										'improvement_id',
									]);
			foreach ($card_data['major_improvements'] as $improvement_id)
			{
				$major_improvements_query->values([
					$score_data['game_id'],
					$score_data['player_order'],
					$improvement_id,
				]);
			}
			try
			{
				$score_query->execute();
				if ($card_data['occupations'] !== [])
				{
					$occupations_query->execute();
				}
				if ($card_data['minor_improvements'] !== [])
				{
					$minor_improvements_query->execute();
				}
				if ($card_data['major_improvements'] !== [])
				{
					$major_improvements_query->execute();
				}
				Response::redirect('result/success');
			}
			catch (DatabaseException $e)
			{
				die('DB Error');
			}
		}
	}

	public function action_success()
	{
		foreach ($this->score_fields as $field)
		{
			Session::delete_flash($field);
		}
		foreach ($this->card_fields as $field)
		{
			Session::delete_flash($field);
		}
		foreach ($this->additional_fields as $field)
		{
			Session::delete_flash($field);
		}
		$this->template->title = '入力完了';
		$this->template->contents = View::forge('result/success');
	}

	private function generate_val()
	{
		$val = Validation::forge();
		$basic_score_fields = [
			'fields' => '畑',
			'pastures' => '牧場',
			'grain' => '小麦',
			'vegetable' => '野菜',
			'sheep' => '羊',
			'boars' => '猪',
			'cattle' => '牛',
		];
		foreach ($basic_score_fields as $field => $label)
		{
			$val->add($field, $label)
				->add_rule('required')
				->add_rule('valid_string', ['numeric'])
				->add_rule('numeric_between', -1, 4);
		}
		$val->add('horses', '馬')
			->add_rule('valid_string', ['numeric'])
			->add_rule('numeric_min', -1);
		$val->add('unused_spaces', '未使用スペース')
			->add_rule('required')
			->add_rule('valid_string', ['numeric'])
			->add_rule('numeric_max', 0);
		$val->add('stables', '柵に囲まれた厩')
			->add_rule('required')
			->add_rule('valid_string', ['numeric'])
			->add_rule('numeric_between', 0, 4);
		$val->add('houses', '家')
			->add_rule('required')
			->add_rule('valid_string', ['numeric'])
			->add_rule('numeric_min', 0);
		$val->add('family', '家族')
			->add_rule('required')
			->add_rule('valid_string', ['numeric'])
			->add_rule('numeric_between', 0, 15);
		$val->add('begging', '物乞いカード')
			->add_rule('required')
			->add_rule('valid_string', ['numeric'])
			->add_rule('numeric_max', 0);
		$val->add('card_points', 'カード点')
			->add_rule('required')
			->add_rule('valid_string', ['numeric']);
		$val->add('bonus_points', 'ボーナス点')
			->add_rule('required')
			->add_rule('valid_string', ['numeric']);
		$val->add('total_score', '合計点')
			->add_rule('required')
			->add_rule('valid_string', ['numeric']);
		$val->add('rank', '順位')
			->add_rule('required')
			->add_rule('valid_string', ['numeric'])
			->add_rule('numeric_between', 1, 5);
		return $val;
	}
}