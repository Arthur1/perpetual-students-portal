<h1 class="orange-text text-darken-2">ユーザー登録</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<div class="row">
	<div class="input-field col s12 m7">
		<?= Form::input('username', Session::get_flash('username'), ['required' => 'required', 'class' => 'input validate', 'maxlength' => '16', 'minlength' => '4', 'data-length' => '16', 'pattern' => '^[-0-9a-zA-Z_]{4,16}$']); ?>
		<label for="form_username" data-error="IDの形式が正しくありません">ID</label>
	</div>
	<div class="col s12 m5">
		<ul>
			<li>英数字・ハイフン・アンダースコアが利用可能</li>
			<li>4文字以上16文字以下</li>
		</ul>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::input('screen_name', Session::get_flash('screen_name'), ['required' => 'required', 'class' => 'input validate', 'maxlength' => '64', 'data-length' => '64']); ?>
		<label for="form_screen_name" data-error="表示名が長すぎます">表示名</label>
	</div>
	<div class="col s12 m5">
		<ul>
			<li>64文字以下</li>
		</ul>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::input('email', Session::get_flash('email'), ['required' => 'required', 'class' => 'input validate', 'type' => 'email']); ?>
		<label for="form_email" data-error="メールアドレスの形式が正しくありません">メールアドレス</label>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::password('password', null, ['required' => 'required', 'class' => 'input validate', 'maxlength' => '32', 'minlength' => '8']); ?>
		<label for="form_password" data-error="パスワードの形式が正しくありません">パスワード</label>
	</div>
	<div class="col s12 m5">
		<ul>
			<li>英数字・ハイフン・アンダースコアが利用可能</li>
			<li>8文字以上32文字以下</li>
		</ul>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::password('password_check', null, ['required' => 'required', 'class' => 'input validate', 'maxlength' => '32', 'minlength' => '8']); ?>
		<label for="form_password_check" data-error="パスワードの形式が正しくありません">パスワード(確認用)</label>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::input('watchword', Session::get_flash('watchword'), ['required' => 'required', 'class' => 'input validate']); ?>
		<label for="form_watchword">合言葉</label>
	</div>
	<div class="col s12 m12">
		<?= Form::submit('submit', '確認', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>