<?php
class Controller_Document extends Controller_Template
{
	public function action_index()
	{
		$this->template->title = '記事一覧';
		$this->template->contents = View::forge('document/index');
	}

	public function action_rule()
	{
		$this->template->title = 'ハウスルール';
		$this->template->contents = View::forge('document/rule');
	}

	public function action_dictionary()
	{
		$this->template->title = '用語集';
		$this->template->contents = View::forge('document/dictionary');
	}

	public function action_sekaai()
	{
		$this->template->title = '世界には愛人がいない';
		$this->template->contents = View::forge('document/sekaai');
	}

	public function action_tweet()
	{
		$this->template->title = 'ツイート集';
		$this->template->contents = View::forge('document/tweet');
	}
}