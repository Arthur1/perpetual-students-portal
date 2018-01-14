<?php
class Controller_Api_Users extends Controller_Rest
{
	public $format = 'json';

	public function get_list()
	{
		$query = DB::select('user_id', 'screen_name', 'icon')
					->from('users_profile')
					->order_by('user_id', 'asc');
		try
		{
			$data = $query->execute()->as_array();
		}
		catch (DatabaseException $e)
		{
			return $this->response(['error' => 'DatabaseException'], 500);
		}
		return $this->response($data);
	}
}