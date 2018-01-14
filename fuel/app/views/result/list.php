<h1 class="orange-text text-darken-1">ゲーム一覧</h1>
<div class="collection">
	<?php foreach ($data as $record): ?>
	<?= Html::anchor('result/article/'.$record['game_id'], date('Y/m/d H:i', $record['game_id']).'<br>'.$record['player_num'].'人 / '.$record['regulation'], ['class' => 'collection-item']); ?>
	<?php endforeach; ?>
</div>
<div class="row">
	<div class="col s12">
		<?php if ($page - 1 > 0): ?>
		<?= Html::anchor('result/list/'.($page - 1), '前のページ', ['class' => 'btn green']); ?>
		<?php else: ?>
		<button class="btn disabled">前のページ</button>
		<?php endif; ?>
		<?php if ($page < intdiv($count, $num)): ?>
		<?= Html::anchor('result/list/'.($page + 1), '次のページ', ['class' => 'btn green']); ?>
		<?php else: ?>
		<button class="btn disabled">次のページ</button>
		<?php endif; ?>
	</div>
</div>