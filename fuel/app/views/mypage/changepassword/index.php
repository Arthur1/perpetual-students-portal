<h1 class="orange-text text-darken-2">パスワード変更</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<div class="row">
	<div class="input-field col s12 m7">
		<?= Form::password('old_password', null, ['required' => 'required', 'class' => 'input validate', 'maxlength' => '32', 'minlength' => '8']); ?>
		<label for="form_new_password" data-error="パスワードの形式が正しくありません">古いパスワード</label>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::password('new_password', null, ['required' => 'required', 'class' => 'input validate', 'maxlength' => '32', 'minlength' => '8']); ?>
		<label for="form_new_password" data-error="パスワードの形式が正しくありません">新しいパスワード</label>
	</div>
	<div class="col s12 m5">
		<ul>
			<li>英数字・ハイフン・アンダースコアが利用可能</li>
			<li>8文字以上32文字以下</li>
		</ul>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::password('new_password_check', null, ['required' => 'required', 'class' => 'input validate', 'maxlength' => '32', 'minlength' => '8']); ?>
		<label for="form_new_password_check" data-error="パスワードの形式が正しくありません">新しいパスワード(確認用)</label>
	</div>
	<div class="col s12 m12">
		<?= Form::submit('submit', '確認', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>