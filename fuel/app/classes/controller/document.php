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
		$this->template->description = '東京工業大学アグリコラサークル「ぶらつき学生連盟」で採用されているハウスルールの紹介です。';
		$this->template->contents = View::forge('document/rule');
	}

	public function action_dictionary()
	{
		$this->template->title = '用語集';
		$this->template->description = '東京工業大学アグリコラサークル「ぶらつき学生連盟」で使用されている用語の紹介です。';
		$this->template->contents = View::forge('document/dictionary');
	}

	public function action_sekaai()
	{
		$this->template->title = '世界には愛人がいない';
		$this->template->description = 'アグリコラ民謡「世界には愛人がいない」の歌詞を掲載しています。';
		$this->template->contents = View::forge('document/sekaai');
	}

	public function action_tweet()
	{
		$this->template->title = 'ツイート集';
		$this->template->description = '東京工業大学アグリコラサークル「ぶらつき学生連盟」メンバーのアグリコラに関するツイートをまとめています。';
		$this->template->contents = View::forge('document/tweet');
	}

	public function action_ttdeck()
	{
		$this->template->title = 'TTデッキ';
		$this->template->description = 'アグリコラオリジナル拡張「TTデッキ」の紹介ページです。';
		$this->template->contents = View::forge('document/ttdeck');
	}
}