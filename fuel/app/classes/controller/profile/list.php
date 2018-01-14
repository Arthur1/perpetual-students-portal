<?php
class Controller_Profile_List extends Controller_Template
{
	public function action_index()
	{
		$query = DB::select()
					->from('users_profile')
					->order_by('user_id', 'asc');
		try
		{
			$data = $query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('データベースエラー');
		}
		$this->template->title = '部員一覧';
		$this->template->contents = View::forge('profile/list');
		$this->template->contents->data = $data;
	}
}