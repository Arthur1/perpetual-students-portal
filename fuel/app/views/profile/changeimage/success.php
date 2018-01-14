<h1 class="orange-text text-darken-2">アイコン設定完了</h1>
<p>
	アイコンの設定に成功しました。
</p>
<ul>
	<li><?= Html::anchor('mypage', 'マイページに戻る'); ?></li>
	<li><?= Html::anchor('profile/show/'.Auth::get_screen_name(), '自分のプロフィールを見る'); ?></li>
</ul>