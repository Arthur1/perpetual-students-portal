<h1 class="orange-text text-darken-2">カード評価編集</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<div class="row">
	<div class="input-field col s12 m7">
		<?= Form::input('points', Session::get_flash('points', Arr::get($opinions_data, '0.points')), ['required' => 'required', 'class' => 'input validate', 'max' => '10', 'min' => '0', 'type' => 'number', 'step' => '0.1']); ?>
		<label for="form_screen_name" data-error="評価点の形式が正しくありません">評価点</label>
	</div>
	<div class="col s12 m5">
		<ul>
			<li>10点満点</li>
			<li>小数も可能</li>
		</ul>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::textarea('opinion', Session::get_flash('opinion', Arr::get($opinions_data, '0.opinion')), ['class' => 'materialize-textarea validate']); ?>
		<label for="form_email" data-error="ひとことの形式が正しくありません">ひとこと(任意)</label>
	</div>
	<div class="col s12">
		<?= Form::submit('submit', '確認', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>