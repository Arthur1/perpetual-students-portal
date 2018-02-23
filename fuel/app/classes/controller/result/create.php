<?php
class Controller_Result_Create extends Controller_Template
{
	private $player_num_list = [
		null => '[未選択]',
		1 => '1人',
		2 => '2人',
		3 => '3人',
		4 => '4人',
		5 => '5人',
	];

	private $regulation_list = [
		null => '[未選択]',
		1 => 'EIK',
		2 => 'EIK＋泥沼',
		3 => '全混ぜ',
		4 => '全混ぜ+泥沼',
		5 => '全混ぜ+Xデッキ',
		6 => 'リバイズド',
	];

	public function before()
	{
		Authplus::check_and_redirect([1]);
		parent::before();
	}

	public function get_index()
	{
		Asset::js('result/create.js', [], 'add_js');
		$this->template->title = 'ゲーム作成';
		$view = View::forge('result/create/index');
		$view->player_num_list = $this->player_num_list;
		$view->regulation_list = $this->regulation_list;
		$this->template->contents = $view;
	}

	public function post_index()
	{
		Asset::js('result/create.js', [], 'add_js');
		$this->template->title = 'ゲーム作成';
		$view = View::forge('result/create/index');
		$view->player_num_list = $this->player_num_list;
		$view->regulation_list = $this->regulation_list;
		if (! Security::check_token())
		{
			$view->error = 'お手数ですが再度送信してください。';
			$this->template->contents = $view;
			return;
		}
		$val = $this->generate_val();
		if (! $val->run())
		{
			$view->error = $val->error();
			$this->template->contents = $view;
			return;
		}
		$game_id = time();
		$overview_query = DB::insert('result_overview')
							->set([
								'game_id' => $game_id,
								'player_num' => Input::post('player_num'),
								'regulation' => $this->regulation_list[Input::post('regulation')],
							]);
		$player_query = DB::insert('result_players')
						->columns([
							'game_id',
							'player_order',
							'player_id',
							'is_edited',
						]);
		$players = Input::post('player');
		foreach ($players as $order => $player)
		{
			$player_query->values([
				$game_id,
				$order + 1,
				$player,
				false,
			]);
		}
		try
		{
			$overview_query->execute();
			$player_query->execute();
		}
		catch (DatabaseException $e)
		{
			$view->error = 'データベースエラーです。';
			$this->template->contents = $view;
			return;
		}
		$notification_endpoints_query = DB::select()
											->from('notification_endpoints')
											->join('users_profile')
											->on('notification_endpoints.user_id', '=', 'users_profile.user_id')
											->where('users_profile.user_id', 'in', $players);
		$notification_endpoints = $notification_endpoints_query->execute()->as_array();
		Config::load('secret');
		$webpush = new \Minishlink\WebPush\WebPush([
			'VAPID' =>  [
				'subject' => 'http://localhost/',
				'publicKey' => Config::get('vapid_public_key'),
				'privateKey' => Config::get('vapid_private_key'),
			],
		]);
		$notification_players = array_column($notification_endpoints, 'user_id');
		foreach ($players as $key => $player)
		{
			$orders[$player] = $key + 1;
		}
		foreach ($notification_endpoints as $record)
		{

			$payload = [
				'title' => 'ぶらつき学生ポータル',
				'message' => $record['screen_name'].'さんのプレイしたゲームが登録されました。',
				'url' => Uri::create('result/edit/'.(string)$game_id.'/'.(string)$orders[$record['user_id']]),
				'icon' => Uri::create('assets/icon/android-chrome-144x144.png'),
			];
			$webpush->sendNotification($record['endpoint'], json_encode($payload), $record['public_key'], $record['auth_secret']);
		}
		$webpush->flush();
		Response::redirect('result/create/success');
	}

	public function action_success()
	{
		$this->template->title = '作成完了';
		$this->template->contents = View::forge('result/create/success');
	}

	private function generate_val()
	{
		$val = Validation::forge();
		$val->add('player_num', '人数')
			->add_rule('required')
			->add_rule('match_collection', range(1, 5));
		$val->add('regulation', 'レギュレーション')
			->add_rule('required');
		return $val;
	}
}