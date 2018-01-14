<?php
class Controller_Profile extends Controller_Template
{
	public function action_show($user_id)
	{
		$this->template->title = 'プロフィール表示ページ';
		$view = View::forge('profile/show');
		$query = DB::select()
					->from('users_profile')
					->where('user_id', '=', $user_id);
		try
		{
			$data = $query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			throw new HttpNotFoundException;
		}
		if ($data === [])
		{
			throw new HttpNotFoundException;
		}
		$view->data = $data[0];
		$this->template->contents = $view;
	}
}