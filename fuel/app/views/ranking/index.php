<h1 class="orange-text text-darken-1">統計</h1>
<p>
	ぶらつき学生ポータルに登録されたデータから算出しています。<br>
	全カードの評価一覧は<?= Html::anchor('cards/opinions', 'こちら'); ?>
</p>
<div class="row">
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">職業評価ベスト5</h2>
		<p>
			()内は平均値。2人以上評価したカードが対象です。
		</p>
		<table class="bordered">
			<?php foreach ($high_rate_occupations_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><span class="new yellow darken-2 badge left" data-badge-caption=""><?= $record['card_id']; ?></span><?= $record['japanese_name']; ?>　<span class="grey-text">(<?= sprintf('%.1f', round($record['average'], 1)); ?>点)</span></td>
				<td><?= Html::anchor('cards/show/'.$record['card_id'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">小進歩評価ベスト5</h2>
		<p>
			()内は平均値。2人以上評価したカードが対象です。
		</p>
		<table class="bordered">
			<?php foreach ($high_rate_minor_improvements_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><span class="new orange darken-2 badge left" data-badge-caption=""><?= $record['card_id']; ?></span><?= $record['japanese_name']; ?>　<span class="grey-text">(<?= sprintf('%.1f', round($record['average'], 1)); ?>点)</span></td>
				<td><?= Html::anchor('cards/show/'.$record['card_id'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">職業評価ワースト5</h2>
		<p>
			()内は平均値。2人以上評価したカードが対象です。
		</p>
		<table class="bordered">
			<?php foreach ($low_rate_occupations_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><span class="new yellow darken-2 badge left" data-badge-caption=""><?= $record['card_id']; ?></span><?= $record['japanese_name']; ?>　<span class="grey-text">(<?= sprintf('%.1f', round($record['average'], 1)); ?>点)</span></td>
				<td><?= Html::anchor('cards/show/'.$record['card_id'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">小進歩評価ワースト5</h2>
		<p>
			()内は平均値。2人以上評価したカードが対象です。
		</p>
		<table class="bordered">
			<?php foreach ($low_rate_minor_improvements_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><span class="new orange darken-2 badge left" data-badge-caption=""><?= $record['card_id']; ?></span><?= $record['japanese_name']; ?>　<span class="grey-text">(<?= sprintf('%.1f', round($record['average'], 1)); ?>点)</span></td>
				<td><?= Html::anchor('cards/show/'.$record['card_id'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">評価が分かれた職業トップ5</h2>
		<p>
			()内は標準偏差
		</p>
		<table class="bordered">
			<?php foreach ($deviate_rate_occupations_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><span class="new yellow darken-2 badge left" data-badge-caption=""><?= $record['card_id']; ?></span><?= $record['japanese_name']; ?>　<span class="grey-text">(<?= sprintf('%.2f', round($record['stddev'], 2)); ?>)</span></td>
				<td><?= Html::anchor('cards/show/'.$record['card_id'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">評価が分かれた小進歩トップ5</h2>
		<p>
			()内は標準偏差
		</p>
		<table class="bordered">
			<?php foreach ($deviate_rate_minor_improvements_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><span class="new orange darken-2 badge left" data-badge-caption=""><?= $record['card_id']; ?></span><?= $record['japanese_name']; ?>　<span class="grey-text">(<?= sprintf('%.2f', round($record['stddev'], 2)); ?>)</span></td>
				<td><?= Html::anchor('cards/show/'.$record['card_id'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">順位が高い部員トップ5</h2>
		<p>
			()内は平均順位。5人ゲーム、また複数回プレイした人が対象。
		</p>
		<table class="bordered">
			<?php foreach ($player_rank_avg_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><?= $record['screen_name']; ?>　<span class="grey-text">(<?= sprintf('%.2f', round($record['average'], 2)); ?>位)</span></td>
				<td><?= Html::anchor('profile/show/'.$record['user_id'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">順位が高い番手ランキング</h2>
		<p>
			()内は平均順位。5人ゲームが対象です。
		</p>
		<table class="bordered">
			<?php foreach ($order_rank_5_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><?= $record['player_order']; ?>番手　<span class="grey-text">(<?= sprintf('%.2f', round($record['average'], 2)); ?>位)</span></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">5グリ全混ぜスコアベスト5</h2>
		<p>
			5人ゲームが対象です。
		</p>
		<table class="bordered">
			<?php foreach ($high_score_5_all_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><?= $record['total_score']; ?>点　<span class="grey-text">(<?= $record['screen_name']; ?>)</span></td>
				<td><?= Html::anchor('result/article/'.$record['game_id'].'#player'.$record['player_order'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
	<div class="col s12 l6">
		<h2 class="green-text text-darken-1">3泥全混ぜスコアベスト5</h2>
		<p>
			3人ゲーム泥沼拡張が対象です。
		</p>
		<table class="bordered">
			<?php foreach ($high_score_3_all_m_data as $record): ?>
			<tr>
				<th><?= $record['ranking']; ?>位</th>
				<td><?= $record['total_score']; ?>点　<span class="grey-text">(<?= $record['screen_name']; ?>)</span></td>
				<td><?= Html::anchor('result/article/'.$record['game_id'].'#player'.$record['player_order'], '詳細'); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>




