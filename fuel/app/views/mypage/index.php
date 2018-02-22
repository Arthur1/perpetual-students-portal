<h1 class="orange-text text-darken-1">マイページ</h1>
ようこそ<?= Auth::get('screen_name'); ?>さん！
<h2 class="green-text text-darken-1">未入力の結果(自分)</h2>
<div class="collection">
	<?php foreach ($my_games as $game): ?>
	<?= Html::anchor('result/edit/'.$game['game_id'].'/'.$game['player_order'], date('Y/m/d H:i', $game['game_id']), ['class' => 'collection-item']); ?>
	<?php endforeach;?>
</div>
<h2 class="green-text text-darken-1">未入力の結果(ゲスト)</h2>
<div class="collection">
	<?php foreach ($guest_games as $game): ?>
	<?= Html::anchor('result/edit/'.$game['game_id'].'/'.$game['player_order'], date('Y/m/d H:i', $game['game_id']), ['class' => 'collection-item']); ?>
	<?php endforeach;?>
</div>
<h2 class="green-text text-darken-1">各種操作</h2>
<div class="collection">
	<?= Html::anchor('result/create', 'ゲームを作成', ['class' => 'collection-item']); ?>
	<?= Html::anchor('profile/show/'.Auth::get_screen_name(), 'プロフィールを表示', ['class' => 'collection-item']); ?>
	<?= Html::anchor('profile/edit', 'プロフィールを変更', ['class' => 'collection-item']); ?>
	<?= Html::anchor('mypage/changepassword', 'パスワードを変更', ['class' => 'collection-item']); ?>
	<?= Html::anchor('logout', 'ログアウト', ['class' => 'collection-item']); ?>
	<?= Html::anchor('register', '新規アカウント登録', ['class' => 'collection-item']); ?>
	<?= Html::anchor('mypage/help', 'ヘルプ', ['class' => 'collection-item']); ?>
</div>
<div id="user_id" class="hide"><?= $user_id; ?></div>
<div id="signature" class="hide"><?= $signature; ?></div>