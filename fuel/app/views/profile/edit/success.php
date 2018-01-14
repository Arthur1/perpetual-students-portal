<h1 class="orange-text text-darken-2">プロフィール編集完了</h1>
<p>
	プロフィールの編集に成功しました。
</p>
<ul>
	<li><?= Html::anchor('mypage', 'マイページに戻る'); ?></li>
	<li><?= Html::anchor('profile/show/'.Auth::get_screen_name(), '自分のプロフィールを見る'); ?></li>
</ul>