<?php
class Controller_Index extends Controller_Template
{
	public function action_index()
	{
		$this->template->title = 'トップページ';
		$this->template->contents = View::forge('index');
	}
}