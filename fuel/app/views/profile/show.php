<h1 class="orange-text text-darken-1">プロフィール</h1>
<div class="row">
	<div class="col s12 m4">
		<?php if ($data['icon'] !== null and $data['icon'] !== ''): ?>
			<?= Asset::img('upload/profile/'.$data['icon'], ['class' => 'responsive-img circle']); ?>
		<?php else: ?>
			NO IMAGE
		<?php endif; ?>
	</div>
	<div class="col s12 m8">
		<dl>
			<dt class="green-text text-darken-1">名前</dt>
			<dd><?= $data['screen_name']; ?></dd>
			<?php if ($data['twitter_id'] !== null and $data['twitter_id'] !== ''): ?>
			<dt class="green-text text-darken-1">Twitter</dt>
			<dd><?= Html::anchor('https://twitter.com/'.$data['twitter_id'], '@'.$data['twitter_id'], ['target' => '_blank']); ?></dd>
			<?php endif;?>
			<?php if ($data['color'] !== null and$data['color'] !== ''): ?>
			<dt class="green-text text-darken-1">好きな駒の色</dt>
			<dd><?= $data['color']; ?></dd>
			<?php endif; ?>
			<?php if ($data['favorite_occupations'] !== null and $data['favorite_occupations'] !== ''): ?>
			<dt class="green-text text-darken-1">好きな職業</dt>
			<dd><?= $data['favorite_occupations']; ?></dd>
			<?php endif; ?>
			<?php if ($data['favorite_improvements'] !== null and $data['favorite_improvements'] !== ''): ?>
			<dt class="green-text text-darken-1">好きな進歩</dt>
			<dd><?= $data['favorite_improvements']; ?></dd>
			<?php endif; ?>
			<?php if ($data['comments'] !== null and $data['comments'] !== ''): ?>
			<dt class="green-text text-darken-1">ひとこと</dt>
			<dd><?= nl2br($data['comments']); ?></dd>
			<?php endif; ?>
		</dl>
	</div>
</div>

<h2 class="green-text text-darken-1">最近のゲーム結果</h2>
<div class="collection">
	<?php foreach ($result_data as $record): ?>
	<?= Html::anchor('result/article/'.$record['game_id'], date('Y/m/d H:i', $record['game_id']).' '.$record['player_num'].'人 '.$record['regulation'].'<br>'.$record['total_score'].'点 '.$record['rank'].'位', ['class' => 'collection-item']); ?>
	<?php endforeach; ?>
</div>