<h1 class="orange-text text-darken-1">部員一覧</h1>
<div class="collection">
	<?php foreach ($data as $record): ?>
	<?= Html::anchor('profile/show/'.$record['user_id'], Asset::img($record['icon'], ['alt' => 'icon', 'class' => 'circle']).$record['screen_name'].'('.$record['user_id'].')', ['class' => 'collection-item avatar']); ?>
	<?php endforeach; ?>
</div>