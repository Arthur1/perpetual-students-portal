<h1 class="orange-text text-darken-2">アイコン設定</h1>
<p>
	jpg,png,gifファイル(5MB)が選択可能です。
</p>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(['enctype' => 'multipart/form-data']); ?>
<div class="row">
	<div class="col s12 l6 file-field input-field">
		<div class="btn green">
			<span>アイコン</span>
			<?= Form::file('image'); ?>
		</div>
		<div class="file-path-wrapper">
			<input class="file-path validate" type="text">
		</div>
	</div>
	<div class="col s12 input-field">
		<?= Form::submit('submit', '設定', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>