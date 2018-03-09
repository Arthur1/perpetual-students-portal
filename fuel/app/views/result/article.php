<h1 class="orange-text text-darken-1">戦績</h1>
<h2 class="green-text text-darken-1">ゲーム概要</h2>
<dl>
	<dt class="green-text text-darken-1">プレイ日時</dt>
	<dd><?= date('Y/m/d H:i', $overview_data['game_id']); ?></dd>
	<dt class="green-text text-darken-1">プレイ人数</dt>
	<dd><?= $overview_data['player_num']; ?>人</dd>
	<dt class="green-text text-darken-1">レギュレーション</dt>
	<dd><?= $overview_data['regulation']; ?></dd>
</dl>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<?= Html::anchor(Uri::create('https://twitter.com/share', [], ['url' => Uri::current(), 'hashtags' => 'ぶらつき学生ポータル']), 'Tweet', ['class' => 'twitter-share-button', 'data-show-count' => 'false']); ?>
<h2 class="green-text text-darken-1">スコア</h2>
<table class="striped">
	<thead>
		<tr>
			<th>プレイヤー名</th>
			<?php foreach ($players_data as $record): ?>
			<th><?= Html::anchor('#player'.$record['player_order'], $record['screen_name']) ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php
		$fields = [
			'fields' => '畑',
			'pastures' => '牧場',
			'grain' => '小麦',
			'vegetable' => '野菜',
			'sheep' => '羊',
			'boars' => '猪',
			'cattle' => '牛',
		];
		foreach ($fields as $field => $label) :
		?>
		<tr>
			<th><?= $label; ?></th>
			<?php for ($i = 1; $i <= $overview_data['player_num']; $i++): ?>
			<td><?= Arr::get($score_data, $i.'.'.$field, '-'); ?></td>
			<?php endfor; ?>
		</tr>
		<?php endforeach; ?>
		<?php if (isset($score_data[1]['horses'])): ?>
		<tr>
			<th>馬</th>
			<?php for ($i = 1; $i <= $overview_data['player_num']; $i++): ?>
			<td><?= Arr::get($score_data, $i.'.horses', '-'); ?></td>
			<?php endfor; ?>
		</tr>
		<?php endif; ?>
		<?php
		$fields = [
			'unused_spaces' => '未使用スペース',
			'stables' => '柵に囲まれた厩',
			'houses' => '家',
			'family' => '家族',
			'begging' => '物乞いカード',
			'card_points' => 'カード点',
			'bonus_points' => 'ボーナス点',
		];
		foreach ($fields as $field => $label) :
		?>
		<tr>
			<th><?= $label; ?></th>
			<?php for ($i = 1; $i <= $overview_data['player_num']; $i++): ?>
			<td><?= Arr::get($score_data, $i.'.'.$field, '-'); ?></td>
			<?php endfor; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr class="yellow lighten-5">
			<th>合計点</th>
			<?php for ($i = 1; $i <= $overview_data['player_num']; $i++): ?>
			<td><?= Arr::get($score_data, $i.'.total_score', '-'); ?></td>
			<?php endfor; ?>
		</tr>
		<tr class="yellow lighten-3">
			<th>順位</th>
			<?php for ($i = 1; $i <= $overview_data['player_num']; $i++): ?>
			<td><?= Arr::get($score_data, $i.'.rank', '-'); ?></td>
			<?php endfor; ?>
		</tr>
	</tfoot>
</table>
<?php foreach ($score_data as $record): ?>
<h2 class="green-text text-darken-1" id="player<?= $record['player_order'] ?>"><?= array_column($players_data, 'screen_name', 'player_order')[$record['player_order']]; ?>(<?= $record['player_order'] ?>番手)の詳細</h2>
<p>
	<?= $record['total_score']; ?>点 / <?= $record['rank']; ?>位
</p>
<div class="row">
	<div class="col s12 m6 l4">
		<h3 class="yellow-text text-darken-2">職業</h3>
		<div class="collection">
			<?php $occupations_key = array_keys(array_column($occupations_data, 'player_order'), $record['player_order']); ?>
			<?php foreach ($occupations_key as $key): ?>
			<a class="collection-item modal-trigger" href="#modal_occupation_<?= $key ?>">
					<?php if (isset($occupations_data[$key]['japanese_name'])): ?>
					<?= $occupations_data[$key]['japanese_name']; ?>
					<span class="new yellow darken-2 badge" data-badge-caption=""><?= $occupations_data[$key]['occupation_id'] ?></span>
					<?php endif; ?>
			</a>
			<?php endforeach; ?>
		</div>
		<?php foreach ($occupations_key as $key): ?>
		<div class="modal" id="modal_occupation_<?= $key ?>">
			<div class="modal-content">
				<?php if (isset($occupations_data[$key]['japanese_name'])): ?>
				<h3 class="yellow-text text-darken-2"><?= $occupations_data[$key]['japanese_name']; ?>
					<span class="new yellow darken-2 badge" data-badge-caption=""><?= $occupations_data[$key]['occupation_id'] ?></span>
				</h3>
				<dl>
					<?php if ($occupations_data[$key]['deck'] !== ''): ?>
					<dt class="green-text">デッキ</dt>
					<dd><?= $deck_list[$occupations_data[$key]['deck']]; ?></dd>
					<?php endif; ?>
					<?php if ($occupations_data[$key]['category'] !== ''): ?>
					<dt class="green-text">カテゴリー</dt>
					<dd><?= $occupations_data[$key]['category'].'+'; ?></dd>
					<?php endif; ?>
				</dl>
				<div><?= nl2br($occupations_data[$key]['description']); ?></div>
				<?= Html::anchor('cards/show/'.$occupations_data[$key]['occupation_id'], 'カードの詳細ページを見る'); ?>
				<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="col s12 m6 l4">
		<h3 class="orange-text text-darken-2">小さい進歩</h3>
		<div class="collection">
			<?php $minor_improvements_key = array_keys(array_column($minor_improvements_data, 'player_order'), $record['player_order']); ?>
			<?php foreach ($minor_improvements_key as $key): ?>
			<a class="collection-item modal-trigger" href="#modal_minor_improvement_<?= $key ?>">
					<?php if (isset($minor_improvements_data[$key]['japanese_name'])): ?>
					<?= $minor_improvements_data[$key]['japanese_name']; ?>
					<span class="new orange darken-2 badge" data-badge-caption=""><?= $minor_improvements_data[$key]['improvement_id'] ?></span>
					<?php endif; ?>
			</a>
			<?php endforeach; ?>
		</div>
		<?php foreach ($minor_improvements_key as $key): ?>
		<div class="modal" id="modal_minor_improvement_<?= $key ?>">
			<div class="modal-content">
				<?php if (isset($minor_improvements_data[$key]['japanese_name'])): ?>
				<h3 class="orange-text text-darken-2"><?= $minor_improvements_data[$key]['japanese_name']; ?>
					<span class="new orange darken-2 badge" data-badge-caption=""><?= $minor_improvements_data[$key]['improvement_id'] ?></span>
				</h3>
				<dl>
					<?php if ($occupations_data[$key]['deck'] !== ''): ?>
					<dt class="green-text">デッキ</dt>
					<dd><?= $deck_list[$occupations_data[$key]['deck']]; ?></dd>
					<?php endif; ?>
					<?php if ($minor_improvements_data[$key]['prerequisite'] !== ''): ?>
					<dt class="green-text">前提</dt>
					<dd><?= $minor_improvements_data[$key]['prerequisite']; ?></dd>
					<?php endif; ?>
					<?php if ($minor_improvements_data[$key]['costs'] !== ''): ?>
					<dt class="green-text">コスト</dt>
					<dd><?= $minor_improvements_data[$key]['costs']; ?></dd>
					<?php endif; ?>
					<?php if ($minor_improvements_data[$key]['card_points'] !== '0'): ?>
					<dt class="green-text">カード点</dt>
					<dd><?= $minor_improvements_data[$key]['card_points'].'点'; ?></dd>
					<?php endif; ?>
				</dl>
				<div><?= nl2br($minor_improvements_data[$key]['description']); ?></div>
				<?= Html::anchor('cards/show/'.$minor_improvements_data[$key]['improvement_id'], 'カードの詳細ページを見る'); ?>
				<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="col s12 m6 l4">
		<h3 class="pink-text text-darken-2">大きい進歩</h3>
		<div class="collection">
			<?php $major_improvements_key = array_keys(array_column($major_improvements_data, 'player_order'), $record['player_order']); ?>
			<?php foreach ($major_improvements_key as $key): ?>
			<a class="collection-item modal-trigger" href="#modal_major_improvement_<?= $key ?>">
					<?php if (isset($major_improvements_data[$key]['japanese_name'])): ?>
					<?= $major_improvements_data[$key]['japanese_name']; ?>
					<span class="new pink darken-2 badge" data-badge-caption=""><?= $major_improvements_data[$key]['improvement_id'] ?></span>
					<?php endif; ?>
			</a>
			<?php endforeach; ?>
		</div>
		<?php foreach ($major_improvements_key as $key): ?>
		<div class="modal" id="modal_major_improvement_<?= $key ?>">
			<div class="modal-content">
				<?php if (isset($major_improvements_data[$key]['japanese_name'])): ?>
				<h3 class="pink-text text-darken-2"><?= $major_improvements_data[$key]['japanese_name']; ?>
					<span class="new pink darken-2 badge" data-badge-caption=""><?= $major_improvements_data[$key]['improvement_id'] ?></span>
				</h3>
				<dl>
					<?php if ($major_improvements_data[$key]['prerequisite'] !== ''): ?>
					<dt class="green-text">前提</dt>
					<dd><?= $major_improvements_data[$key]['prerequisite']; ?></dd>
					<?php endif; ?>
					<?php if ($major_improvements_data[$key]['costs'] !== ''): ?>
					<dt class="green-text">コスト</dt>
					<dd><?= $major_improvements_data[$key]['costs']; ?></dd>
					<?php endif; ?>
					<?php if ($major_improvements_data[$key]['card_points'] !== '0'): ?>
					<dt class="green-text">カード点</dt>
					<dd><?= $major_improvements_data[$key]['card_points'].'点'; ?></dd>
					<?php endif; ?>
				</dl>
				<div><?= nl2br($major_improvements_data[$key]['description']); ?></div>
				<?= Html::anchor('cards/show/'.$major_improvements_data[$key]['improvement_id'], 'カードの詳細ページを見る'); ?>
				<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php if ($record['comments'] !== ''): ?>
	<div class="col s12 m6 l8">
		<h3 class="green-text text-lighten-1">ひとこと</h3>
		<p><?= nl2br($record['comments']); ?></p>
	</div>
	<?php endif; ?>
	<?php if ($record['image_path'] !== null): ?>
	<div class="col s12 m6 l4">
		<h3 class="green-text text-lighten-1">盤面の画像</h3>
		<?= Asset::img('upload/result/'.$record['image_path'], ['class' => 'responsive-img']); ?>
	</div>
	<?php endif; ?>
	<div class="col s12">
		<div class="collection">
			<div class="collection-item avatar">
				<?php
					$player_record = array_column($players_data, null, 'player_order')[$record['player_order']];
				?>
				<a href="/profile/show/<?= $player_record['user_id']; ?>">
					<?= Asset::img($player_record['icon'], ['class' => 'circle']); ?>
				</a>
				<?= $player_record['screen_name']; ?> (<?= $player_record['user_id']; ?>)<br>
				<span class="grey-text"><?= $player_record['comments']; ?></span><br>
				<?= Html::anchor('profile/show/'.$player_record['user_id'], 'プロフィールはこちら'); ?>
			</div>
		</div>
	</div>
</div>

<?php endforeach; ?>