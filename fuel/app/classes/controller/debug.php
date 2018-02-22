<?php
class Controller_Debug extends Controller
{
	public function before()
	{
		parent::before();
		Authplus::check_and_redirect([1]);
		if (Auth::get_screen_name() !== 'Arthur')
		{
			throw new HttpNotFoundException;
		}
	}

	public function action_usericon()
	{
		$users_profile = DB::select()->from('users_profile')->execute()->as_array();
		foreach ($users_profile as $record)
		{
			Auth::update_user(['icon' => $record['icon']], $record['user_id']);
		}
		return 'Success';
	}
}