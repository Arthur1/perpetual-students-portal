<h1 class="orange-text text-darken-1">プロフィール</h1>
<div class="row">
	<div class="col s12 m4">
		<img src="https://pbs.twimg.com/profile_images/936629123765567488/yhndhwmr_400x400.jpg" class="responsive-img circle">
	</div>
	<div class="col s12 m8">
		<dl>
			<dt class="green-text text-darken-1">名前</dt>
			<dd><?= $data['screen_name']; ?></dd>
			<?php if (isset($data['twitter_id'])): ?>
			<dt class="green-text text-darken-1">Twitter</dt>
			<dd><?= Html::anchor('https://twitter.com/'.$data['twitter_id'], '@'.$data['twitter_id'], ['target' => '_blank']); ?></dd>
			<?php endif;?>
			<dt class="green-text text-darken-1">好きな職業</dt>
			<dd><?= $data['favorite_occupations']; ?></dd>
			<dt class="green-text text-darken-1">好きな進歩</dt>
			<dd><?= $data['favorite_improvements']; ?></dd>
			<dt class="green-text text-darken-1">ひとこと</dt>
			<dd><?= nl2br($data['comments']); ?></dd>
		</dl>
	</div>
</div>

<h2 class="green-text text-darken-1">最近のゲーム結果</h2>
<div class="collection">
	<?php foreach ($result_data as $record): ?>
	<?= Html::anchor('result/article/'.$record['game_id'], date('Y/m/d H:i', $record['game_id']).' '.$record['player_num'].'人 '.$record['regulation'].'<br>'.$record['total_score'].'点 '.$record['rank'].'位', ['class' => 'collection-item']); ?>
	<?php endforeach; ?>
</div>