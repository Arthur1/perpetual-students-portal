<h1 class="orange-text text-darken-2">カード評価編集</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?php
$major_improvements_list = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'M001', 'M002', 'M003', 'M004', 'M005', 'M006', 'M007', 'M008', 'M009', 'M010', 'M011', 'M012', 'M013', 'M014'];
?>
<?php if (isset($card_data['category'])): ?>
<h2 class="yellow-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new yellow darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h2>
<?php elseif (in_array($card_id, $major_improvements_list, true)): ?>
<h2 class="pink-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new pink darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h2>
<?php else: ?>
<h2 class="orange-text text-darken-2"><?= $card_data['japanese_name']; ?><span class="new orange darken-2 badge" data-badge-caption=""><?= $card_id; ?></span></h2>
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
<?= Form::open(); ?>
<div class="row">
	<div class="input-field col s12 m7">
		<?= Form::input('points', Session::get_flash('points', Arr::get($opinions_data, '0.points')), ['required' => 'required', 'class' => 'input validate', 'max' => '10', 'min' => '0', 'type' => 'number', 'step' => '0.1']); ?>
		<label for="form_screen_name" data-error="評価点の形式が正しくありません">評価点</label>
	</div>
	<div class="col s12 m5">
		<ul>
			<li>10点満点</li>
			<li>小数も可能</li>
		</ul>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::textarea('opinion', Session::get_flash('opinion', Arr::get($opinions_data, '0.opinion')), ['class' => 'materialize-textarea validate']); ?>
		<label for="form_email" data-error="ひとことの形式が正しくありません">ひとこと(任意)</label>
	</div>
	<div class="col s12">
		<?= Form::submit('submit', '確認', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>