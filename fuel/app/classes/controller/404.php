<?php
class Controller_404 extends Controller_Template
{
	public function action_index()
	{
		$this->template->title = '404';
		$this->template->contents = View::forge('404');
	}

	public function after($response)
	{
		$response = parent::after($response);
		$response->status = 404;
		return $response;
	}
}