<h1 class="orange-text text-darken-1">カード評価一覧</h1>
<p>
	表のヘッダーをクリックするとソートできます。
</p>
<div class="row">
	<div class="col s12">
		<ul class="tabs">
			<li class="tab col s6"><a href="#occupations_box" class="active yellow-text text-darken-2" style="font-size: 1.5em">職業</a></li>
			<li class="tab col s6"><a href="#improvements_box" class="orange-text text-darken-2" style="font-size: 1.5em">小さい進歩</a></li>
			<li class="indicator green" style="z-index:1"></li>
		</ul>
	</div>
	<div id="occupations_box" class="col s12">
		<h2 class="yellow-text text-darken-2">職業</h2>
		<table class="striped tablesorter" id="occupations">
		<thead>
			<tr>
				<th style="cursor:pointer">カード名</th>
				<th></th>
				<th style="cursor:pointer">平均</th>
				<?php foreach ($users as $user_id => $screen_name): ?>
				<th style="cursor:pointer"><?= mb_strimwidth($screen_name, 0, 10, '…'); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($occupations_data as $record): ?>
			<tr>
				<td>
					<span class="new yellow darken-2 badge left" data-badge-caption="">
						<?= $record['card_id'] ?>
					</span>
					<?= $record['japanese_name']; ?>
				</td>
				<td><?= Html::anchor('cards/show/'.$record['card_id'], '詳細'); ?></td>
				<td><?= sprintf('%.2f', round($record['average'], 2)); ?></td>
				<?php foreach ($users as $user_id => $screen_name): ?>
				<td><?= isset($record[$user_id]) ? $record[$user_id] : '-'; ?></td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
	<div id="improvements_box" class="col s12">
		<h2 class="orange-text text-darken-2">小さい進歩</h2>
		<table class="striped tablesorter" id="improvements">
		<thead>
			<tr>
				<th>カード名</th>
				<th></th>
				<th>平均</th>
				<?php foreach ($users as $user_id => $screen_name): ?>
				<th><?= mb_strimwidth($screen_name, 0, 10, '…'); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($improvements_data as $record): ?>
			<tr>
				<td>
					<span class="new orange darken-2 badge left" data-badge-caption="">
						<?= $record['card_id'] ?>
					</span>
					<?= $record['japanese_name']; ?>
				</td>
				<td><?= Html::anchor('cards/show/'.$record['card_id'], '詳細'); ?></td>
				<td><?= sprintf('%.2f', round($record['average'], 2)); ?></td>
				<?php foreach ($users as $user_id => $screen_name): ?>
				<td><?= isset($record[$user_id]) ? $record[$user_id] : '-'; ?></td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
		</table>
	</div>
</div>
