<?php
$major_improvements_list = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'M001', 'M002', 'M003', 'M004', 'M005', 'M006', 'M007', 'M008', 'M009', 'M010', 'M011', 'M012', 'M013', 'M014'];
?>
<?php if (isset($card_data['category'])): ?>
<h1 class="yellow-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new yellow darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h1>
<?php elseif (in_array($card_id, $major_improvements_list, true)): ?>
<h1 class="pink-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new pink darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h1>
<?php else: ?>
<h1 class="orange-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new orange darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h1>
<?php endif; ?>
<dl>
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