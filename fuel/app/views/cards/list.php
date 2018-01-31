<h1 class="orange-text text-darken-1">カード一覧</h1>
<div class="row">
	<div class="col s12 m8">
		<div class="collection">
		<?php foreach ($data as $record): ?>
		<?php
			$major_improvements_list = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'M001', 'M002', 'M003', 'M004', 'M005', 'M006', 'M007', 'M008', 'M009', 'M010', 'M011', 'M012', 'M013', 'M014'];
			if ($record['type'] === 'occupations')
			{
				$record['color'] = 'yellow';
			}
			elseif (in_array($record['card_id'], $major_improvements_list, true))
			{
				$record['color'] = 'pink';
			}
			else
			{
				$record['color'] = 'orange';
			}
		?>
		<a href="/cards/show/<?= $record['card_id'] ?>" class="collection-item">
			<?= $record['japanese_name']; ?>
			<span class="new <?= $record['color'] ?> darken-2 badge" data-badge-caption=""><?= $record['card_id']; ?></span>
		</a>
		<?php endforeach; ?>
		</div>
		<div class="row">
			<div class="col s12">
				<?php if ($page - 1 > 0): ?>
				<?= Html::anchor('cards/list/'.($page - 1), '前のページ', ['class' => 'btn green']); ?>
				<?php else: ?>
				<button class="btn disabled">前のページ</button>
				<?php endif; ?>
				<?php if ($page < intdiv($count, $num)): ?>
				<?= Html::anchor('cards/list/'.($page + 1), '次のページ', ['class' => 'btn green']); ?>
				<?php else: ?>
				<button class="btn disabled">次のページ</button>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col s12 m4">
		<h2 class="green-text text-darken-1">カード検索</h2>
		<p>
			検索ワードは部分一致です。(たとえば、WMデッキのみを検索したければ、カード番号のところにWMと入れる)
		</p>
		<?= Form::open(['method' => 'get', 'action' => '/cards/search']); ?>
		<div class="row">
			<div class="input-field col s12">
				<?= Form::input('card_id', null, ['class' => 'input']); ?>
				<label for="form_card_id">カード番号</label>
			</div>
			<div class="input-field col s12">
				<?= Form::input('japanese_name', null, ['class' => 'input']); ?>
				<label for="form_japanese_name">カード名</label>
			</div>
			<div class="col s12 l6">
				<?= Form::checkbox('occupations', true, null, ['checked' => 'checked']); ?>
				<label for="form_occupations">職業</label>
			</div>
			<div class="col s12 l6">
				<?= Form::checkbox('improvements', true, null, ['checked' => 'checked']); ?>
				<label for="form_improvements">進歩</label>
			</div>
			<div class="col s12 input-field">
				<?= Form::submit('submit', '検索', ['class' => 'btn green right']); ?>
			</div>
		</div>
		<?= Form::close(); ?>
	</div>
</div>
