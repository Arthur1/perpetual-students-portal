<h1 class="orange-text text-darken-1">スコア入力</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<p>以下の情報が正しいか確認した上で入力してください。</p>
<dl>
	<dt class="green-text text-darken-1">ゲーム作成日時</dt>
	<dd><?= date('Y/m/d H:i', $data['game_id']); ?></dd>
	<dt class="green-text text-darken-1">あなたのID・番手</dt>
	<dd><?= $data['player_id'] ?> / <?= $data['player_order']; ?>番手</dd>
</dl>
<?= Form::open(['enctype' => 'multipart/form-data']); ?>
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
?>
<h2 class="green-text text-darken-1">得点</h2>
<p>
	得点を半角数字で入力してください。「馬」は「泥沼からの出発」拡張を使用したときのみ入力してください。
</p>
<div class="row">
	<?php foreach ($fields as $field => $label): ?>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input($field, Session::get_flash($field), ['class' => 'input validate', 'type' => 'number', 'min' => '-1', 'max' => '4', 'required']); ?>
		<label for="form_<?= $field ?>" data-error="値が正しくありません"><?= $label ?></label>
	</div>
	<?php endforeach; ?>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('horses', Session::get_flash('horses'), ['class' => 'input validate', 'type' => 'number', 'min' => '-1']); ?>
		<label for="form_horses" data-error="値が正しくありません">馬</label>
	</div>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('unused_spaces', Session::get_flash('unused_spaces'), ['class' => 'input validate', 'type' => 'number', 'max' => '0']); ?>
		<label for="form_unused_spaces" data-error="値が正しくありません">未使用スペース</label>
	</div>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('stables', Session::get_flash('stables'), ['class' => 'input validate', 'type' => 'number', 'min' => '0', 'max' => '4']); ?>
		<label for="form_stables" data-error="値が正しくありません">柵に囲まれた厩</label>
	</div>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('houses', Session::get_flash('houses'), ['class' => 'input validate', 'type' => 'number', 'min' => '0', 'max' => '30']); ?>
		<label for="form_houses" data-error="値が正しくありません">家</label>
	</div>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('family', Session::get_flash('family'), ['class' => 'input validate', 'type' => 'number', 'min' => '0', 'max' => '15']); ?>
		<label for="form_family" data-error="値が正しくありません">家族</label>
	</div>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('begging', Session::get_flash('begging'), ['class' => 'input validate', 'type' => 'number', 'max' => '0']); ?>
		<label for="form_begging" data-error="値が正しくありません">物乞いカード</label>
	</div>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('card_points', Session::get_flash('card_points'), ['class' => 'input validate', 'type' => 'number']); ?>
		<label for="form_card_points" data-error="値が正しくありません">カード点</label>
	</div>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('bonus_points', Session::get_flash('bonus_points'), ['class' => 'input validate', 'type' => 'number']); ?>
		<label for="form_bonus_points" data-error="値が正しくありません">ボーナス点</label>
	</div>
	<div class="col s12 l6 input-field">
		<button type="button" class="btn green" id="calc_btn">合計点を計算する</button>
	</div>
</div>
<div class="row">
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('total_score', Session::get_flash('total_score'), ['class' => 'input validate', 'type' => 'number']); ?>
		<label for="form_total_score" data-error="値が正しくありません">合計点</label>
	</div>
	<div class="col s4 m3 l2">
		<div class="input-field inline">
			<?= Form::input('rank', Session::get_flash('rank'), ['class' => 'input validate', 'type' => 'number', 'min' => '1', 'max' => '5']); ?>
			<label for="form_rank" data-error="値が正しくありません">順位</label>
		</div>
		位
	</div>
</div>
<h2 class="green-text text-darken-1">カード</h2>
<p>
	カード番号を半角数字で入力してください。
</p>
<div class="row" id="occupations_box">
<?php
$occupations = Session::get_flash('occupations');
foreach ((array)$occupations as $occupation) :
?>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('occupations[]', $occupation, ['class' => 'input validate']); ?>
		<label for="form_occupations" data-error="値が正しくありません">職業</label>
	</div>
<?php endforeach; ?>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('occupations[]', null, ['class' => 'input validate']); ?>
		<label for="form_occupations" data-error="値が正しくありません">職業</label>
	</div>
	<div class="col s4 m3 l2 input-field" id="occupations_btn_box">
		<button type="button" class="btn yellow darken-2" id="occupations_btn">+</button>
	</div>
</div>
<div class="row" id="minor_improvements_box">
<?php
$minor_improvements = Session::get_flash('minor_improvements');
foreach ((array)$minor_improvements as $minor_improvement) :
?>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('minor_improvements[]', $minor_improvement, ['class' => 'input validate']); ?>
		<label for="form_minor_improvements" data-error="値が正しくありません">小さい進歩</label>
	</div>
<?php endforeach; ?>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('minor_improvements[]', null, ['class' => 'input validate']); ?>
		<label for="form_minor_improvements" data-error="値が正しくありません">小さい進歩</label>
	</div>
	<div class="col s4 m3 l2 input-field" id="minor_improvements_btn_box">
		<button type="button" class="btn orange darken-2" id="minor_improvements_btn">+</button>
	</div>
</div>
<div class="row" id="major_improvements_box">
<?php
$major_improvements = Session::get_flash('major_improvements');
foreach ((array)$major_improvements as $major_improvement) :
?>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('major_improvements[]', $major_improvement, ['class' => 'input validate']); ?>
		<label for="form_major_improvements" data-error="値が正しくありません">大きい進歩</label>
	</div>
<?php endforeach; ?>
	<div class="col s4 m3 l2 input-field">
		<?= Form::input('major_improvements[]', null, ['class' => 'input validate']); ?>
		<label for="form_major_improvements" data-error="値が正しくありません">大きい進歩</label>
	</div>
	<div class="col s4 m3 l2 input-field" id="major_improvements_btn_box">
		<button type="button" class="btn pink darken-2" id="major_improvements_btn">+</button>
	</div>
</div>
<h2 class="green-text text-darken-1">その他</h2>
<p>
	画像はpng,jpg,gifのみ。最大サイズは2MBです。
</p>
<div class="row">
	<div class="col s12 l6 file-field input-filed">
		<div class="btn green">
			<span>盤面の画像</span>
			<?= Form::file('image'); ?>
		</div>
		<div class="file-path-wrapper">
			<input class="file-path validate" type="text">
		</div>
	</div>
	<div class="col s12 l9 input-field">
		<?= Form::textarea('comments', Session::get_flash('comments'), ['class' => 'materialize-textarea validate']); ?>
		<label for="form_comments">ひとこと</label>
	</div>
</div>
<div class="row">
	<div class="col s12 input-field">
		<?= Form::submit('submit', '確認', ['class' => 'btn green']); ?>
	</div>
</div>
<?= Form::csrf(); ?>
<?= Form::close(); ?>
