<h1 class="orange-text text-darken-1">マイページ</h1>
ようこそ<?= Auth::get('screen_name'); ?>さん！
<h2 class="green-text text-darken-1">未入力の結果(自分)</h2>
<ul>
	<?php foreach ($my_games as $game): ?>
	<li><?= Html::anchor('result/edit/'.$game['game_id'].'/'.$game['player_order'], date('Y/m/d H:i', $game['game_id'])); ?></li>
	<?php endforeach;?>
</ul>
<h2 class="green-text text-darken-1">未入力の結果(ゲスト)</h2>
<ul>
	<?php foreach ($guest_games as $game): ?>
	<li><?= Html::anchor('result/edit/'.$game['game_id'].'/'.$game['player_order'], date('Y/m/d H:i', $game['game_id'])); ?></li>
	<?php endforeach;?>
</ul>
<h2 class="green-text text-darken-1">各種操作</h2>
<ul class="collection">
	<li class="collection-item"><?= Html::anchor('result/create', 'ゲームを作成'); ?></li>
	<li class="collection-item"><?= Html::anchor('profile/show/'.Auth::get_screen_name(), 'プロフィールを表示'); ?></li>
	<li class="collection-item"><?= Html::anchor('profile/edit', 'プロフィールを変更'); ?></li>
	<li class="collection-item"><?= Html::anchor('mypage/changepassword', 'パスワードを変更'); ?></li>
	<li class="collection-item"><?= Html::anchor('logout', 'ログアウト'); ?></li>
	<li class="collection-item"><?= Html::anchor('register', '新規アカウント登録'); ?></li>
</ul>