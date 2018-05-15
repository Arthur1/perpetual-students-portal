<h1 class="orange-text text-darken-1">初手ピックシミュレーター</h1>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<?= Html::anchor(Uri::create('https://twitter.com/share', [], ['url' => Uri::create('pick/vote', [], Input::get()), 'hashtags' => 'ぶらつき学生ポータル']), 'Tweet', ['class' => 'twitter-share-button', 'data-show-count' => 'false']); ?>
<p>
	投票機能はまだ実装していません。旧版5グリを想定しています。
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