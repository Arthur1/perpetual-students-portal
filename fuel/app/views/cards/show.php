<?php if ($type === 'occupation'): ?>
<h1 class="yellow-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new yellow darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h1>
<?php elseif ($type === 'major_improvement'): ?>
<h1 class="pink-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new pink darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h1>
<?php else: ?>
<h1 class="orange-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new orange darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h1>
<?php endif; ?>
<dl>
	<?php if (! empty($card_data['deck'])): ?>
	<dt class="green-text text-darken-1">デッキ</dt>
	<dd><?= $deck_list[$card_data['deck']]; ?></dd>
	<?php endif; ?>
	<?php if (isset($card_data['category'])): ?>
	<dt class="green-text text-darken-1">カテゴリー</dt>
	<dd><?= $card_data['category']; ?>+</dd>
	<?php endif; ?>
	<?php if (isset($card_data['prerequisite']) and $card_data['prerequisite'] !== ''): ?>
	<dt class="green-text text-darken-1">条件</dt>
	<dd><?= $card_data['prerequisite']; ?></dd>
	<?php endif; ?>
	<?php if (isset($card_data['costs']) and $card_data['costs'] !== ''): ?>
	<dt class="green-text text-darken-1">コスト</dt>
	<dd><?= $card_data['costs']; ?></dd>
	<?php endif; ?>
	<?php if (isset($card_data['card_points']) and $card_data['card_points'] !== '0'): ?>
	<dt class="green-text text-darken-1">カード点</dt>
	<dd><?= $card_data['card_points']; ?>点</dd>
	<?php endif; ?>
	<dt class="green-text text-darken-1">効果</dt>
	<dd><?= nl2br($card_data['description']); ?></dd>
</dl>
<?php if (Authplus::check([1])): ?>
<?= Html::anchor('/cards/edit/'.$card_id, 'カード評価を入力する'); ?>
<?php endif; ?>
<h2 class="green-text text-darken-1">カード評価</h2>
<?php if ($opinions_data !== []): ?>
<div class="collection">
	<?php if ($average !== null): ?>
	<div class="collection-item">
		平均評価：<span style="font-size: 1.5rem; line-height: 2rem;"><?= sprintf('%.1f', round($average, 1)); ?>点</span>
	</div>
	<?php endif; ?>
	<?php if ($pick_data !== []): ?>
	<div class="collection-item">
		初手ピック率：<span style="font-size: 1.5rem; line-height: 2rem;"><?= sprintf('%d', $pick_data[0]['pick_rate'] * 100); ?>%</span>
	</div>
	<?php endif; ?>
<?php foreach ($opinions_data as $record): ?>
	<div class="collection-item avatar">
		<div>
			<?= Html::anchor('profile/show/'.$record['user_id'], Asset::img($record['icon'], ['alt' => 'icon', 'class' => 'circle'])); ?>
			<?= Html::anchor('profile/show/'.$record['user_id'], $record['screen_name']); ?>
		</div>
		<div class="row">
			<div class="col s4 m2 grey-text" style="font-size: 1.5rem; line-height: 2rem;"><?= $record['points']; ?>点</div>
			<div class="col s8 m10"><?= nl2br($record['opinion']); ?></div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<?php else: ?>
<p>まだこのカードに対する評価が入力されていません。</p>
<?php endif; ?>
<h2 class="green-text text-darken-1">使用されたゲーム</h2>
<?php if ($game_data === []): ?>
<p>まだこのカードは使用されていません。</p>
<?php else: ?>
<div class="collection">
	<div class="collection-item">
		使用された総回数：<span style="font-size: 1.5rem; line-height: 2rem;"><?= count($game_data); ?>回</span>
	</div>
	<?php foreach ($game_data as $record): ?>
	<a href="/result/article/<?= $record['game_id']."#player".$record['player_order']; ?>" class="collection-item avatar">
		<?= Asset::img($record['icon'], ['class' => 'circle', 'alt' => 'users_icon']); ?>
		<?= $record['screen_name']; ?><br>
		<?= date('Y/m/d H:i', $record['game_id']).' '.$record['player_num'].'人 '.$record['regulation'].'<br>'.$record['player_order'].'番手 '.$record['total_score'].'点 '.$record['rank'].'位'; ?>
	</a>
	<?php endforeach; ?>
</div>
<?php endif; ?>