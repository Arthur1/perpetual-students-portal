<?php
class Controller_Profile_Changeimage extends Controller_Template
{
	public function before()
	{
		Authplus::check_and_redirect([1]);
		parent::before();
	}

	public function action_index()
	{
		$this->template->title = 'アイコン変更';
		$this->template->contents = View::forge('profile/changeimage/index');
		if (Input::post('submit'))
		{
			if (! Security::check_token())
			{
				$this->template->contents->error = 'お手数ですが、再度送信してください。';
				return;
			}
			Upload::process([
				'path' => DOCROOT.'assets/img/upload/profile',
				'ext_whitelist' => ['jpg', 'jpeg', 'png', 'gif'],
				'new_name' => Auth::get_screen_name(),
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
			$query = DB::update('users_profile')
						->set(['icon' => 'upload/profile/'.Upload::get_files('image')['saved_as']])
						->where('user_id', '=', Auth::get_screen_name());
			try
			{
				$query->execute();
				Response::redirect('profile/changeimage/success');
			}
			catch (DatabaseException $e)
			{
				$this->template->contents->error = 'データベースエラー';
				return;
			}
		}
	}

	public function action_success()
	{
		$this->template->title = 'アイコン設定完了';
		$this->template->contents = View::forge('profile/changeimage/success');
	}
}