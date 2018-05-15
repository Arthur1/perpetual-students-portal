<h1 class="orange-text text-darken-1">初手ピックシミュレーター</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?php $message = Session::get_flash('message'); ?>
<?php if ($message !== null): ?>
<h2 class="blue-text">投票完了</h2>
<p><?= $message; ?></p>
<?php endif; ?>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<?= Html::anchor(Uri::create('https://twitter.com/share', [], ['url' => Uri::create('pick/vote', [], Input::get()), 'hashtags' => 'ぶらつき学生ポータル']), 'Tweet', ['class' => 'twitter-share-button', 'data-show-count' => 'false']); ?>
<p>
	旧版5グリを想定しています。よろしければ下の投票にご協力ください。
</p>
<dl>
	<dt class="green-text">あなたの手番</dt>
	<dd><?= Input::get('o'); ?>番手</dd>
</dl>
<div class="row">
	<div class="col s12 m6">
		<h3 class="yellow-text text-darken-2">職業</h3>
		<div class="collection">
			<?php foreach ($occupations_data as $key => $record): ?>
			<a class="collection-item modal-trigger" href="#modal_occupation_<?= $key ?>">
					<?php if (isset($record['japanese_name'])): ?>
					<?= $record['japanese_name']; ?>
					<span class="new yellow darken-2 badge" data-badge-caption=""><?= $record['occupation_id'] ?></span>
					<?php endif; ?>
			</a>
			<?php endforeach; ?>
		</div>
		<?php foreach ($occupations_data as $key => $record): ?>
		<div class="modal" id="modal_occupation_<?= $key ?>">
			<div class="modal-content">
				<?php if (isset($record['japanese_name'])): ?>
				<h3 class="yellow-text text-darken-2"><?= $record['japanese_name']; ?>
					<span class="new yellow darken-2 badge" data-badge-caption=""><?= $record['occupation_id'] ?></span>
				</h3>
				<dl>
					<?php if ($record['deck'] !== ''): ?>
					<dt class="green-text">デッキ</dt>
					<dd><?= $deck_list[$record['deck']]; ?></dd>
					<?php endif; ?>
					<?php if ($record['category'] !== ''): ?>
					<dt class="green-text">カテゴリー</dt>
					<dd><?= $record['category'].'+'; ?></dd>
					<?php endif; ?>
				</dl>
				<div><?= nl2br($record['description']); ?></div>
				<?= Html::anchor('cards/show/'.$record['occupation_id'], 'カードの詳細ページを見る'); ?>
				<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="col s12 m6">
		<h3 class="orange-text text-darken-2">小さい進歩</h3>
		<div class="collection">
			<?php foreach ($improvements_data as $key => $record): ?>
			<a class="collection-item modal-trigger" href="#modal_improvement_<?= $key ?>">
					<?php if (isset($record['japanese_name'])): ?>
					<?= $record['japanese_name']; ?>
					<span class="new orange darken-2 badge" data-badge-caption=""><?= $record['improvement_id'] ?></span>
					<?php endif; ?>
			</a>
			<?php endforeach; ?>
		</div>
		<?php foreach ($improvements_data as $key => $record): ?>
		<div class="modal" id="modal_improvement_<?= $key ?>">
			<div class="modal-content">
				<?php if (isset($record['japanese_name'])): ?>
				<h3 class="orange-text text-darken-2"><?= $record['japanese_name']; ?>
					<span class="new orange darken-2 badge" data-badge-caption=""><?= $record['improvement_id'] ?></span>
				</h3>
				<dl>
					<?php if ($record['deck'] !== ''): ?>
					<dt class="green-text">デッキ</dt>
					<dd><?= $deck_list[$record['deck']]; ?></dd>
					<?php endif; ?>
					<?php if ($record['prerequisite'] !== ''): ?>
					<dt class="green-text">前提</dt>
					<dd><?= $record['prerequisite']; ?></dd>
					<?php endif; ?>
					<?php if ($record['costs'] !== ''): ?>
					<dt class="green-text">コスト</dt>
					<dd><?= $record['costs']; ?></dd>
					<?php endif; ?>
					<?php if ($record['card_points'] !== '0'): ?>
					<dt class="green-text">カード点</dt>
					<dd><?= $record['card_points'].'点'; ?></dd>
					<?php endif; ?>
				</dl>
				<div><?= nl2br($record['description']); ?></div>
				<?= Html::anchor('cards/show/'.$record['improvement_id'], 'カードの詳細ページを見る'); ?>
				<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<?= Form::open('/pick/vote?p='.urlencode(Input::get('p')).'&o='.Input::get('o')); ?>
<?php
$occupation_list[null] = '[未選択]';
$improvement_list[null] = '[未選択]';
foreach ($occupations_data as $record)
{
	$occupation_list[$record['occupation_id']] = '['.$record['occupation_id'].']'.$record['japanese_name'];
}
foreach ($improvements_data as $record)
{
	$improvement_list[$record['improvement_id']] = '['.$record['improvement_id'].']'.$record['japanese_name'];
}
?>
<h2 class="green-text text-darken-1">投票</h2>
<p>
	この投票にはメンバー以外の方も投票できます。
</p>
<div class="row">
	<div class="col s12 m6 l6 input-field">
		<?= Form::select('occupation', Input::post('occupation'), $occupation_list, ['required' => 'required', 'class' => 'input']); ?>
		<label for="form_occupation">職業</label>
	</div>
	<div class="col s12 m6 l6 input-field">
		<?= Form::select('improvement', Input::post('submit'), $improvement_list, ['required' => 'required', 'class' => 'input']); ?>
		<label for="form_improvement">小さい進歩</label>
	</div>
	<div class="col s12 input-field">
		<?= Form::submit('submit', '送信', ['class' => 'btn green']); ?>
	</div>
</div>
<?= Form::csrf(); ?>
<?= Form::close(); ?>