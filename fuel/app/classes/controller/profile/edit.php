<?php
class Controller_Profile_Edit extends Controller_Template
{
	private $fields = [
		'screen_name',
		'twitter_id',
		'color',
		'favorite_occupations',
		'favorite_improvements',
		'comments',
	];

	public function before()
	{
		Authplus::check_and_redirect([1]);
		parent::before();
	}

	public function action_index()
	{
		$this->template->title = 'プロフィール編集ページ';
		$this->template->contents = View::forge('profile/edit/index');
		$query = DB::select()
					->from('users_profile')
					->where('user_id', '=', Auth::get_screen_name());
		try
		{
			$data = $query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		$this->template->contents->data = $data[0];
		if (Input::post('submit'))
		{
			foreach ($this->fields as $field)
			{
				Session::set_flash($field, Input::post($field));
			}
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください。';
				return;
			}
			$val = $this->generate_val();
			if (! $val->run())
			{
				$this->template->contents->error = $val->error();
				return;
			}
			Response::redirect('profile/edit/confirm');
		}
	}

	public function action_confirm()
	{
		foreach ($this->fields as $field)
		{
			$data[$field] = Session::get_flash($field);
			Session::keep_flash($field);
		}
		if ($data['screen_name'] === null)
		{
			throw new HttpNotFoundException;
		}
		$this->template->title = '確認ページ';
		$this->template->contents = View::forge('profile/edit/confirm');
		$this->template->contents->data = $data;
		if (Input::post('return'))
		{
			Response::redirect('profile/edit');
		}
		if (Input::post('submit'))
		{
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください。';
				return;
			}
			$query = DB::update('users_profile')
						->set($data)
						->where('user_id', '=', Auth::get_screen_name());
			try
			{
				$query->execute();
				Auth::update_user(['screen_name' => $data['screen_name']]);
				Response::redirect('profile/edit/success');
			}
			catch (DatabaseException $e)
			{
				$this->template->contents->error = 'データベースエラーです。';
				return;
			}
		}
	}

	public function action_success()
	{
		foreach ($this->fields as $field)
		{
			Session::delete_flash($field);
		}
		$this->template->title = '編集完了';
		$this->template->contents = View::forge('profile/edit/success');
	}

	private function generate_val()
	{
		$val = Validation::forge();
		$val->add('screen_name', '表示名')
			->add_rule('required')
			->add_rule('max_length', 64);
		$val->add('twitter_id', 'Twitter ID')
			->add_rule('valid_string', ['alpha', 'numeric', 'dashes']);
		return $val;
	}
}