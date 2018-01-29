<?php
class Controller_Mypage extends Controller_Template
{
	public function before()
	{
		Authplus::check_and_redirect([1]);
		parent::before();
	}

	public function action_index()
	{
		$this->template->title = 'マイページ';
		$view = View::forge('mypage/index');
		$my_games_query = DB::select()
							->from('result_players')
							->where('player_id', '=', Auth::get_screen_name())
							->and_where('is_edited', '=', false);
		$guest_games_query = DB::select()
							->from('result_players')
							->where('player_id', '=', 'guest')
							->and_where('is_edited', '=', false);
		try
		{
			$my_games = $my_games_query->execute()->as_array();
			$guest_games = $guest_games_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DBERROR');
		}
		$view->my_games = $my_games;
		$view->guest_games = $guest_games;
		$this->template->contents = $view;
	}

	public function action_help()
	{
		$this->template->title = 'ヘルプ';
		$this->template->contents = View::forge('mypage/help');
	}
}