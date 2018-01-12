<h1 class="orange-text text-darken-2">ログイン</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<div class="row">
	<div class="input-field col s6">
		<?= Form::input('username', Input::post('username'), ['required' => 'required', 'class' => 'input']); ?>
		<label for="form_username">ID</label>
	</div>
	<div class="input-field col s6">
		<?= Form::password('password', null, ['required' => 'required']); ?>
		<label for="form_password">PASSWORD</label>
	</div>
</div>

<?= Form::csrf(); ?>
<?= Form::submit('submit', '送信', ['class' => 'btn green']); ?>
<?= Form::close(); ?>