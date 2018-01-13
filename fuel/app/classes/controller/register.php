<?php
class Controller_Register extends Controller_Template
{
	private $fields = [
		'username',
		'screen_name',
		'email',
		'password',
		'password_check',
		'watchword',
	];
	public function action_index()
	{
		$this->template->title = '登録ページ';
		$this->template->contents = View::forge('register/index');
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
			Response::redirect('register/confirm');
		}
	}

	public function action_confirm()
	{
		$this->template->title = '確認ページ';
		$this->template->contents = View::forge('register/confirm');
		foreach ($this->fields as $field)
		{
			$data[$field] = Session::get_flash($field);
			Session::keep_flash($field);
		}
		/*if ($data['username'] === null)
		{
			throw new HttpNotFoundException;
		}*/
		$this->template->contents->data = $data;
		if (Input::post('return'))
		{
			Response::redirect('register');
		}
		if (Input::post('submit'))
		{
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください。';
				return;
			}
			$val = $this->generate_val();
			if (! $val->run($data))
			{
				$this->template->contents->error = $val->error();
				return;
			}
			try
			{
				$flag = Auth::create_user($data['username'], $data['password'], $data['email'], 1, ['screen_name' => $data['screen_name']]);
				if ($flag === false)
				{
					$this->template->contents->error = '予期せぬエラーが発生しました。';
					return;
				}
				DB::insert('users_profile')
					->set([
						'user_id' => $data['username'],
						'screen_name' => $data['screen_name'],
					])->execute();
			}
			catch (SimpleUserUpdateException $e)
			{
				$this->template->contents->error = '予期せぬエラーが発生しました。';
				return;
			}
			catch (DatabaseException $e)
			{
				$this->template->contents->error = 'データベースエラーです。';
				return;
			}
			Auth::login($data['username'], $data['password']);
			Response::redirect('mypage');
		}
	}

	private function generate_val()
	{
		$val = Validation::forge();
		$val->add('username', 'ID')
			->add_rule('required')
			->add_rule('valid_string', ['alpha', 'numeric', 'dashes'])
			->add_rule('min_length', 4)
			->add_rule('max_length', 16)
			->add_rule(['unique_username' => function($username) {
				$record = DB::select()
							->from('users')
							->where('username', '=', $username)
							->execute()->as_array();
				if ($record !== [])
				{
					Validation::active()->set_message('unique_username', 'すでに同IDのユーザーが存在します。');
                    return false;
				}
				return true;
			}]);
		$val->add('screen_name', '表示名')
			->add_rule('required')
			->add_rule('max_length', 64);
		$val->add('email', 'メールアドレス')
			->add_rule('required')
			->add_rule('valid_email')
			->add_rule(['unique_email' => function($email) {
				$record = DB::select()
							->from('users')
							->where('email', '=', $email)
							->execute()->as_array();
				if ($record !== [])
				{
					Validation::active()->set_message('unique_email', 'このメールアドレスはすでに登録されています。');
                    return false;
				}
				return true;
			}]);
		$val->add('password', 'パスワード')
			->add_rule('required')
			->add_rule('valid_string', ['alpha', 'numeric', 'dashes'])
			->add_rule('min_length', 8)
			->add_rule('max_length', 32);
		$val->add('password_check', 'パスワード(確認)')
			->add_rule('required')
			->add_rule('match_field', 'password');
		$val->add('watchword', '合言葉')
			->add_rule('required')
			->add_rule('match_value', 'しおれた彫刻家', true);
		$val->set_message('match_value', '合言葉が違います。');
		return $val;
	}
}