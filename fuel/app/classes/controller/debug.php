<?php
class Controller_Debug extends Controller
{
	public function before()
	{
		parent::before();
		Authplus::check_and_redirect([1]);
		if (Auth::get_screen_name() !== 'Arthur')
		{
			throw new HttpNotFoundException;
		}
	}

	public function action_usericon()
	{
		$users_profile = DB::select()->from('users_profile')->execute()->as_array();
		foreach ($users_profile as $record)
		{
			Auth::update_user(['icon' => $record['icon']], $record['user_id']);
		}
		return 'Success';
	}

	public function action_notification()
	{
		Config::load('secret');
		$webpush = new \Minishlink\WebPush\WebPush([
			'VAPID' =>  [
				'subject' => 'http://localhost/',
				'publicKey' => Config::get('vapid_public_key'),
				'privateKey' => Config::get('vapid_private_key'),
			],
		]);
		$payload = [
			'title' => 'ぶらつき学生ポータル',
			'message' => '通知テストです。111111111',
			'url' => 'http://localhost/profile/show/Arthur',
			'icon' => 'http://localhost/assets/img/upload/profile/Arthur.jpg',
		];

		$res = $webpush->sendNotification(
			'https://fcm.googleapis.com/fcm/send/ezA-CTVQ1Qw:APA91bELmTlhHKDxPZk1Du2qb63UYwCUPB-sY51gajIje--ehtymwf6i0ees-2DmDc1LxwOlb96miJYM90L4Te5p6blIEQYViIv4uoiBPRY4wBl-5x3l-t08DxVKIBS9bRaIsDcVS_Pi',
			json_encode( $payload ), // jsonで送ると、pushイベントでjsonでデータを取得できる。
			'BPy_8sKYfY-TI8ekVcFwHxOXooAdZK0PE12WWnLFTZsgJABtgK3Mm20audG8O1jS3cy3pO06b_hvizJv0HNhm2E',
			'Yhy4l5GEYJq2laeJoD9mqQ',
			true
		);
	}
}