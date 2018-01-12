<?php
class Controller_Logout extends Controller_Template
{
	public function action_index()
	{
		Auth::logout();
		$this->template->title = 'ログアウト';
		$this->template->contents = View::forge('logout');
	}
}