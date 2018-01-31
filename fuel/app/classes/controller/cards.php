<?php
class Controller_Cards extends Controller_Template
{
	public function action_list()
	{

	}

	public function action_search()
	{

	}

	public function action_show($card_id)
	{
		$this->template->title = 'カード詳細【'.$card_id.'】';
		$this->template->contents = View::forge('cards/show');
		$occupations_query = DB::select()
								->from('cards_occupations')
								->where('occupation_id', '=', $card_id);
		$improvements_query = DB::select()
								->from('cards_improvements')
								->where('improvement_id', '=', $card_id);
		try
		{
			$card_data = $occupations_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		if ($card_data === [])
		{
			try
			{
				$card_data = $improvements_query->execute()->as_array();
			}
			catch (DatabaseException $e)
			{
				die('DB Error');
			}
			if ($card_data === [])
			{
				throw new HttpNotFoundException;
			}
		}
		$opinions_query = DB::select()
							->from('cards_opinions')
							->where('card_id', '=', $card_id)
							->join('users_profile', 'inner')
							->on('cards_opinions.user_id', '=', 'users_profile.user_id');
		try
		{
			$opinions_data = $opinions_query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			die('DB Error');
		}
		$this->template->contents->card_id = $card_id;
		$this->template->contents->card_data = $card_data[0];
		$this->template->contents->opinions_data = $opinions_data;
	}
}