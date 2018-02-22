<?php
class Controller_Profile extends Controller_Template
{
	public function action_show($user_id)
	{
		$view = View::forge('profile/show');
		$query = DB::select()
					->from('users_profile')
					->where('user_id', '=', $user_id);
		$result_query = DB::select()
							->from('result_players')
							->where('player_id', '=', $user_id)
							->order_by('result_players.game_id', 'desc')
							->limit(10)
							->join('result_score', 'inner')
							->on('result_players.game_id', '=', 'result_score.game_id')
							->and_on('result_players.player_order', '=', 'result_score.player_order')
							->join('result_overview', 'inner')
							->on('result_players.game_id', '=', 'result_overview.game_id');
		try
		{
			$data = $query->execute()->as_array();
			$result_data = $result_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			throw new HttpNotFoundException;
		}
		if ($data === [])
		{
			throw new HttpNotFoundException;
		}
		$this->template->title = $data[0]['screen_name'].'のプロフィール';
		$this->template->description = '東京工業大学アグリコラサークル「ぶらつき学生連盟」メンバーのプロフィールやプレイしたゲーム一覧を掲載しています。';
		$this->template->ogp_image = $data[0]['icon'];
		$view->data = $data[0];
		$view->result_data = $result_data;
		$this->template->contents = $view;
	}
}