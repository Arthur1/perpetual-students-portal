<?php
class Controller_Api_Notification extends Controller_Rest
{
	private $crypto_key;
	private $crypto_salt;
	public $format = 'json';

	public function post_register()
	{
		Config::load('secret');
		$crypto_key = Config::get('notification_crypto_key');
		$crypto_salt = Config::get('notification_crypto_salt');
		$data = Input::post();
		if ($data['signature'] !== hash_hmac('sha256', $data['user_id'].$crypto_salt, $crypto_key))
		{
			return $this->response(['error' => 'Authentication Failed', 'input' => Input::post()], 400);
		}
		$query = DB::select()
					->from('users')
					->where('username', '=', $data['user_id']);
		try
		{
			if ($query->execute()->as_array() === [])
			{
				return $this->response(['error' => 'Unregistered User'], 400);
			}
		}
		catch (DatabaseException $e)
		{
			return $this->response(['error' => 'Database Error1'], 400);
		}
		unset($data['signature']);
		$query = DB::query('
			INSERT IGNORE notification_endpoints
			(user_id, endpoint, public_key, auth_secret, content_encoding)
			VALUES
			(:user_id, :endpoint, :public_key, :auth_secret, :content_encoding)
		');
		foreach ($data as $key => $value)
		{
			$query->param($key, $value);
		}
		try
		{
			$query->execute();
			return $this->response($data);
		}
		catch (DatabaseException $e)
		{
			return $this->response(['error' => 'Database Error2'], 400);
		}

	}
}