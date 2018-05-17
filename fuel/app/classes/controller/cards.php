<?php
class Controller_Cards extends Controller_Template
{
	private $fields = [
		'points',
		'opinion',
	];

	private $deck_list = [
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

	private $form_deck_list = [
		null => 'すべてのデッキ',
		'基本セット' => [
			'E' => 'Eデッキ',
			'I' => 'Iデッキ',
			'K' => 'Kデッキ',
			'EIK' => 'EIK全て',
		],
		'BI' => 'BIデッキ',
		'C' => 'Čデッキ',
		'FL' => 'FLデッキ',
		'FR' => 'FRデッキ',
		'G' => 'Gデッキ',
		'NL' => 'NLデッキ',
		'O' => 'Öデッキ',
		'P' => 'πデッキ',
		'WA' => 'WA デッキ',
		'WMデッキ' => [
			'alpha' => 'αデッキ',
			'beta' => 'βデッキ',
			'gamma' => 'γデッキ',
			'epsilon' => 'εデッキ',
			'delta' => 'δデッキ',
			'WM' => 'WMデッキ全て',
		],
		'Z' => 'Zデッキ',
		'泥沼からの出発' => [
			'ME' => 'Eデッキ(泥沼)',
			'MF' => 'Fデッキ',
			'M' => 'EF両方',
		],
	];

	public function action_list($page = 1)
	{
		$num = 30;
		$this->template->title = 'カード一覧';
		$this->template->description = '東京工業大学アグリコラサークル「ぶらつき学生連盟」で使用しているカードの一覧です。';
		$this->template->contents = View::forge('cards/list');
		$count_query = DB::select(DB::expr('COUNT(*) as count'))
						->from('cards_list');
		try
		{
			$count = $count_query->execute()->as_array()[0]['count'];
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		if ($page > ceil($count / $num) or $page <= 0)
		{
			throw new HttpNotFoundException;
		}
		$data_query = DB::select()
					->from('cards_list')
					->order_by('card_id', 'asc')
					->limit($num)
					->offset(($page - 1) * $num);
		try
		{
			$data = $data_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		Asset::js(['card.js'], [], 'add_js');
		$this->template->contents->num = $num;
		$this->template->contents->page = $page;
		$this->template->contents->count = $count;
		$this->template->contents->data = $data;
		$this->template->contents->deck_list = $this->form_deck_list;
	}

	public function action_search()
	{
		Asset::js(['card.js'], [], 'add_js');
		$this->template->title = 'カード検索';
		$this->template->contents = View::forge('cards/search');
		$this->template->description = '東京工業大学アグリコラサークル「ぶらつき学生連盟」で使用しているカードの検索結果です。';
		$data_query = DB::select()
			->from('cards_list');
		if (! empty(Input::get('card_id')))
		{
			$data_query->and_where('card_id', '=', Input::get('card_id'));
		}
		if (! empty(Input::get('japanese_name')))
		{
			$data_query->and_where('japanese_name', 'like', '%'.Input::get('japanese_name').'%');
		}
		if (! empty(Input::get('deck')))
		{
			switch (Input::get('deck'))
			{
				case 'EIK':
					$data_query->and_where('deck', 'in', ['E', 'I', 'K']);
					break;
				case 'M':
					$data_query->and_where('deck', 'in', ['ME', 'MF']);
					break;
				case 'WM':
					$data_query->and_where('deck', 'in', ['alpha', 'beta', 'gamma', 'epsilon', 'delta']);
					break;
				default:
					$data_query->and_where('deck', '=', Input::get('deck'));
					break;
			}
		}
		if (Input::get('occupations') === '1' and Input::get('improvements') !== '1')
		{
			$data_query->and_where('type', '=', 'occupations');
		}
		elseif (Input::get('occupations') !== '1' and Input::get('improvements') === '1')
		{
			$data_query->and_where('type', '=', 'improvements');
		}
		elseif (Input::get('occupations') !== '1' and Input::get('improvements') !== '1')
		{
			$data_query->and_where('type', '=', 'unchi');
		}
		$data_query->order_by('card_id', 'asc');
		try
		{
			$data = $data_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		$this->template->contents->data = $data;
		$this->template->contents->deck_list = $this->form_deck_list;

	}

	public function action_show($card_id)
	{
		$major_improvements_list = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'M001', 'M002', 'M003', 'M004', 'M005', 'M006', 'M007', 'M008', 'M009', 'M010', 'M011', 'M012', 'M013', 'M014'];
		$this->template->contents = View::forge('cards/show');
		$occupations_query = DB::select()
								->from('cards_occupations')
								->where('occupation_id', '=', $card_id);
		$improvements_query = DB::select()
								->from('cards_improvements')
								->where('improvement_id', '=', $card_id);
		try
		{
			$card_data = $occupations_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		if ($card_data === [])
		{
			try
			{
				$card_data = $improvements_query->execute()->as_array();
			}
			catch (DatabaseException $e)
			{
				die('DB Error');
			}
			if ($card_data === [])
			{
				throw new HttpNotFoundException;
			}
			if (in_array($card_data[0]['improvement_id'], $major_improvements_list))
			{
				$type = 'major_improvement';
			}
			else
			{
				$type = 'minor_improvement';
			}
		}
		else
		{
			$type = 'occupation';
		}
		$opinions_query = DB::select()
							->from('cards_opinions')
							->where('card_id', '=', $card_id)
							->join('users_profile', 'inner')
							->on('cards_opinions.user_id', '=', 'users_profile.user_id');
		$game_query = DB::select()
						->from('result_'.$type.'s')
						->join('result_overview')
						->on('result_'.$type.'s.game_id', '=', 'result_overview.game_id')
						->join('result_players')
						->on('result_'.$type.'s.game_id', '=', 'result_players.game_id')
						->on('result_'.$type.'s.player_order', '=', 'result_players.player_order')
						->join('users_profile')
						->on('result_players.player_id', '=', 'users_profile.user_id')
						->join('result_score')
						->on('result_'.$type.'s.game_id', '=', 'result_score.game_id')
						->on('result_'.$type.'s.player_order', '=', 'result_score.player_order');
		switch ($type)
		{
			case 'occupation':
				$game_query->where('occupation_id', '=', $card_id);
				$pick_query = DB::select('occupation_id', DB::expr('AVG(`is_picked`) AS `pick_rate`'))
									->from('pick_occupations')
									->where('occupation_id', '=', $card_id);
				break;
			case 'minor_improvement':
				$game_query->where('improvement_id', '=', $card_id);
				$pick_query = DB::select('improvement_id', DB::expr('AVG(`is_picked`) AS `pick_rate`'))
									->from('pick_improvements')
									->where('improvement_id', '=', $card_id);
				break;
			case 'major_improvement':
				$game_query->where('improvement_id', '=', $card_id);
				break;
		}
		$game_query->order_by('result_overview.game_id', 'desc');
		$avg_query = DB::select(DB::expr('AVG(points) AS `average`'))
						->from('cards_opinions')
						->where('card_id', '=', $card_id);
		try
		{
			$opinions_data = $opinions_query->execute()->as_array();
			$game_data = $game_query->execute()->as_array();
			$avg_data = $avg_query->execute()->as_array();
			$pick_data = isset($pick_query) ? $pick_query->execute()->as_array() : [];
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		$this->template->description = '【'.$card_id.'】'.$card_data[0]['japanese_name'].' のカード効果や、「ぶらつき学生連盟」メンバーによる評価、使用されたゲーム一覧を掲載しています。';
		$this->template->title = 'カード詳細【'.$card_id.'】'.$card_data[0]['japanese_name'];
		$this->template->contents->game_data = $game_data;
		$this->template->contents->average = $avg_data === [] ? null : $avg_data[0]['average'];
		$this->template->contents->type = $type;
		$this->template->contents->card_id = $card_id;
		$this->template->contents->card_data = $card_data[0];
		$this->template->contents->opinions_data = $opinions_data;
		$this->template->contents->deck_list = $this->deck_list;
		$this->template->contents->pick_data = $pick_data;
	}

	public function action_edit($card_id)
	{
		Authplus::check_and_redirect([1]);
		$this->template->title = 'カード評価入力【'.$card_id.'】';
		$this->template->contents = View::forge('cards/edit');
		$occupations_query = DB::select()
								->from('cards_occupations')
								->where('occupation_id', '=', $card_id);
		$improvements_query = DB::select()
								->from('cards_improvements')
								->where('improvement_id', '=', $card_id);
		try
		{
			$card_data = $occupations_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		if ($card_data === [])
		{
			try
			{
				$card_data = $improvements_query->execute()->as_array();
			}
			catch (DatabaseException $e)
			{
				die('DB Error');
			}
			if ($card_data === [])
			{
				throw new HttpNotFoundException;
			}
		}
		$opinions_query = DB::select()
							->from('cards_opinions')
							->where('card_id', '=', $card_id)
							->and_where('user_id', '=', Auth::get_screen_name());
		try
		{
			$opinions_data = $opinions_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		$this->template->contents->card_id = $card_id;
		$this->template->contents->card_data = $card_data[0];
		$this->template->contents->opinions_data = $opinions_data;
		$this->template->contents->deck_list = $this->deck_list;
		if (Input::post('submit'))
		{
			foreach ($this->fields as $field)
			{
				Session::set_flash($field, Input::post($field));
			}
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください';
				return;
			}
			$val = Validation::forge();
			$val->add('points', '評価点')
				->add_rule('required')
				->add_rule('valid_string', ['numeric', 'dots'])
				->add_rule('numeric_between', 0, 10);
			if (! $val->run())
			{
				$this->template->contents->error = $val->error();
				return;
			}
			Session::set_flash('card_id', $card_id);
			Response::redirect('cards/confirm');
		}

	}

	public function action_confirm()
	{
		Authplus::check_and_redirect([1]);
		$data['user_id'] = Auth::get_screen_name();
		$this->template->title = '確認ページ';
		$this->template->contents = View::forge('cards/confirm');
		$data['card_id'] = Session::get_flash('card_id');
		Session::keep_flash('card_id');
		if ($data['card_id'] === null)
		{
			throw new HttpNotFoundException;
		}
		foreach ($this->fields as $field)
		{
			$data[$field] = Session::get_flash($field);
			Session::keep_flash($field);
		}
		$this->template->contents->data = $data;
		if (Input::post('return'))
		{
			Response::redirect('cards/edit/'.$data['card_id']);
		}
		if (Input::post('submit'))
		{
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください';
				return;
			}
			$query = DB::query('
					INSERT INTO cards_opinions (card_id, user_id, points, opinion)
					VALUES (:card_id, :user_id, :points, :opinion)
					ON DUPLICATE KEY UPDATE points = :points, opinion = :opinion ;
					')
					->bind('card_id', $data['card_id'])
					->bind('user_id', $data['user_id'])
					->bind('points', $data['points'])
					->bind('opinion', $data['opinion']);
			try
			{
				$query->execute();
				Response::redirect('cards/success/'.$data['card_id']);
			}
			catch (DatabaseException $e)
			{
				$this->template->contents->error = 'DB Error';
				return;
			}
		}
	}

	public function action_success($card_id)
	{
		Authplus::check_and_redirect([1]);
		foreach ($this->fields as $field)
		{
			Session::delete_flash($field);
		}
		$this->template->title = '編集完了';
		$this->template->contents = View::forge('cards/success');
		$this->template->contents->card_id = $card_id;
	}

	public function action_opinions()
	{
		$this->template->title = 'カード評価一覧';
		$this->template->description = '「ぶらつき学生ポータル」に登録されたカード評価を集計したランキングです。';
		$this->template->contents = View::forge('cards/opinions');
		Asset::js(['jquery.tablesorter.min.js', 'opinions.js'], [], 'add_js');

		$occupations_avg_query = DB::query('
			SELECT card_id, japanese_name, average, pick_rate
			FROM cards_occupations
			INNER JOIN (
				SELECT cards_opinions.card_id, AVG(points) AS average
				FROM cards_opinions
				JOIN cards_list
				ON cards_opinions.card_id = cards_list.card_id
				WHERE cards_list.type collate utf8mb4_general_ci = "occupations"
				GROUP BY cards_opinions.card_id
			) opinions
			ON cards_occupations.occupation_id = opinions.card_id
			LEFT OUTER JOIN (
				SELECT pick_occupations.occupation_id, AVG(is_picked) AS pick_rate
				FROM pick_occupations
				GROUP BY pick_occupations.occupation_id
			) pick
			ON cards_occupations.occupation_id = pick.occupation_id
			ORDER BY card_id asc
		');
		$occupations_avg_data = $occupations_avg_query->execute()->as_array();
		$occupations_data = array_column($occupations_avg_data, null, 'card_id');
		$occupations_ids = array_keys($occupations_data);
		$occupations_records_query = DB::select('user_id', 'card_id', 'points')
										->from('cards_opinions')
										->where('card_id', 'in', $occupations_ids);
		$occupations_records = $occupations_records_query->execute()->as_array();
		foreach ($occupations_records as $record)
		{
			$occupations_data[$record['card_id']][$record['user_id']] = $record['points'];
		}
		$this->template->contents->occupations_data = $occupations_data;

		$improvements_avg_query = DB::query('
			SELECT card_id, japanese_name, average, pick_rate
			FROM cards_improvements
			INNER JOIN (
				SELECT cards_opinions.card_id, AVG(points) AS average
				FROM cards_opinions
				JOIN cards_list
				ON cards_opinions.card_id = cards_list.card_id
				WHERE cards_list.type collate utf8mb4_general_ci = "improvements"
				AND cards_list.card_id NOT IN ("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "M001", "M002", "M003", "M004", "M005", "M006", "M007", "M008", "M009", "M010", "M011", "M012", "M013", "M014")
				GROUP BY cards_opinions.card_id
			) opinions
			ON cards_improvements.improvement_id = opinions.card_id
			LEFT OUTER JOIN (
				SELECT pick_improvements.improvement_id, AVG(is_picked) AS pick_rate
				FROM pick_improvements
				GROUP BY pick_improvements.improvement_id
			) pick
			ON cards_improvements.improvement_id = pick.improvement_id
			ORDER BY card_id asc
		');
		$improvements_avg_data = $improvements_avg_query->execute()->as_array();
		$improvements_data = array_column($improvements_avg_data, null, 'card_id');
		$improvements_ids = array_keys($improvements_data);
		$improvements_records_query = DB::select('user_id', 'card_id', 'points')
										->from('cards_opinions')
										->where('card_id', 'in', $improvements_ids);
		$improvements_records = $improvements_records_query->execute()->as_array();
		foreach ($improvements_records as $record)
		{
			$improvements_data[$record['card_id']][$record['user_id']] = $record['points'];
		}
		$this->template->contents->improvements_data = $improvements_data;

		$users_query = DB::select('cards_opinions.user_id', 'screen_name')
						->from('cards_opinions')
						->join('users_profile')
						->on('cards_opinions.user_id', '=', 'users_profile.user_id')
						->group_by('cards_opinions.user_id');
		$users_data = $users_query->execute()->as_array();
		$users = array_column($users_data, 'screen_name', 'user_id');
		$this->template->contents->users = $users;
	}
}