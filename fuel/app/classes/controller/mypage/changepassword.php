<?php
class Controller_Mypage_Changepassword extends Controller_Template
{
	public function before()
	{
		Authplus::check_and_redirect([1]);
		parent::before();
	}

	public function action_index()
	{
		$this->template->title = 'パスワード変更';
		$this->template->contents = View::forge('mypage/changepassword/index');
		if (Input::post('submit'))
		{
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
			try
			{
				if (! Auth::change_password(Input::post('old_password'), Input::post('new_password')))
				{
					$this->template->contents->error = '古いパスワードが違います。';
					return;
				}
				Session::set_flash('changepassword_flag', true);
				Response::redirect('mypage/changepassword/success');
			}
			catch (SimpleUserUpdateException $e)
			{
				$this->template->contents->error = '予期せぬエラーが発生しました。';
				return;
			}
		}
	}

	public function action_success()
	{
		if (Session::get_flash('changepassword_flag') === null)
		{
			throw new HttpNotFoundException;
		}
		Session::delete_flash('changepassword_flag');
		Auth::logout();
		$this->template->title = 'パスワード変更完了';
		$this->template->contents = View::forge('mypage/changepassword/success');
	}

	private function generate_val()
	{
		$val = Validation::forge();
		$val->add('old_password', '古いパスワード')
			->add_rule('required')
			->add_rule('valid_string', ['alpha', 'numeric', 'dashes'])
			->add_rule('min_length', 8)
			->add_rule('max_length', 32);
		$val->add('new_password', '新しいパスワード')
			->add_rule('required')
			->add_rule('valid_string', ['alpha', 'numeric', 'dashes'])
			->add_rule('min_length', 8)
			->add_rule('max_length', 32);
		$val->add('new_password_check', '新しいパスワード(確認)')
			->add_rule('required')
			->add_rule('match_field', 'new_password');
		return $val;
	}
}