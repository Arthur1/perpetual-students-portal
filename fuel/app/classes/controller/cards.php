<?php
class Controller_Cards extends Controller_Template
{
	private $fields = [
		'points',
		'opinion',
	];

	public function action_list($page = 1)
	{
		$num = 30;
		$this->template->title = 'カード一覧';
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
		$this->template->contents->num = $num;
		$this->template->contents->page = $page;
		$this->template->contents->count = $count;
		$this->template->contents->data = $data;
	}

	public function action_search()
	{
		$this->template->title = 'カード検索';
		$this->template->contents = View::forge('cards/search');
		$data_query = DB::select()
			->from('cards_list');
		if (Input::get('card_id') != null)
		{
			$data_query->and_where('card_id', 'like', '%'.Input::get('card_id').'%');
		}
		if (Input::get('japanese_name') != null)
		{
			$data_query->and_where('japanese_name', 'like', '%'.Input::get('japanese_name').'%');
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
	}

	public function action_show($card_id)
	{
		$this->template->title = 'カード詳細【'.$card_id.'】';
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
		}
		$opinions_query = DB::select()
							->from('cards_opinions')
							->where('card_id', '=', $card_id)
							->join('users_profile', 'inner')
							->on('cards_opinions.user_id', '=', 'users_profile.user_id');
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
}