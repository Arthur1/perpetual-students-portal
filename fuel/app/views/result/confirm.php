<h1 class="orange-text text-darken-2">確認ページ</h1>
<p>
	以下の情報が正しいか確認し、「登録」ボタンを押してください。
</p>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<h2 class="green-text text-darken-2">ゲーム情報</h2>
<dl>
	<dt class="green-text text-darken-1">ゲーム作成日時</dt>
	<dd><?= date('Y/m/d H:i', $score_data['game_id']); ?></dd>
	<dt class="green-text text-darken-1">あなたの番手</dt>
	<dd><?= $score_data['player_order']; ?>番手</dd>
</dl>
<h2 class="green-text text-darken-2">得点</h2>
<table class="striped">
	<thead>
		<tr>
			<th>項目</th>
			<th>得点</th>
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
			<td><?= $label; ?></td>
			<td><?= $score_data[$field]; ?></td>
		</tr>
		<?php endforeach; ?>
		<?php if ($score_data['horses'] !== null and $score_data['horses'] !== ''): ?>
		<tr>
			<td>馬</td>
			<td><?= $score_data['horses']; ?></td>
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
			<td><?= $label; ?></td>
			<td><?= $score_data[$field]; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr class="yellow lighten-5">
			<td>合計点</td>
			<td><?= $score_data['total_score']; ?></td>
		</tr>
		<tr class="yellow lighten-3">
			<td>順位</td>
			<td><?= $score_data['rank']; ?></td>
		</tr>
	</tfoot>
</table>
<h2 class="green-text text-darken-1">カード</h2>
<dl>
	<dt class="yellow-text text-darken-2">職業</dt>
	<dd><?= implode('・', (array) $card_data['occupations']); ?></dd>
	<dt class="orange-text text-darken-2">小さい進歩</dt>
	<dd><?= implode('・', (array) $card_data['minor_improvements']); ?></dd>
	<dt class="pink-text text-darken-2">大きい進歩</dt>
	<dd><?= implode('・', (array) $card_data['major_improvements']); ?></dd>
</dl>
<?php if (isset($score_data['image_path'])): ?>
<h2 class="green-text text-darken-1">盤面の画像</h2>
<?= Asset::img('upload/result/'.$score_data['image_path'], ['class' => 'responsive-img']); ?>
<?php endif; ?>
<h2 class="green-text text-darken-1">ひとこと</h2>
<p><?= nl2br($score_data['comments']); ?></p>
<div class="row">
	<div class="col s12 input-field">
		<?= Form::submit('return', '戻る', ['class' => 'btn grey']); ?>
		<?= Form::submit('submit', '登録', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>