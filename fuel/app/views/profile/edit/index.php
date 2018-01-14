<h1 class="orange-text text-darken-2">プロフィール編集</h1>
<p>
	アイコンの変更は<?= Html::anchor('profile/changeimage', 'こちら'); ?>
</p>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<div class="row">
	<div class="input-field col s12 m7">
		<?= Form::input('screen_name', Session::get_flash('screen_name', $data['screen_name']), ['required' => 'required', 'class' => 'input validate', 'maxlength' => '64', 'data-length' => '64']); ?>
		<label for="form_screen_name" data-error="表示名が長すぎます">表示名</label>
	</div>
	<div class="col s12 m5">
		<ul>
			<li>64文字以下</li>
		</ul>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::input('twitter_id', Session::get_flash('twitter_id', $data['twitter_id']), ['class' => 'input validate']); ?>
		<label for="form_email" data-error="Twitter IDの形式が正しくありません">Twitter ID(任意)</label>
	</div>
	<div class="col s12 m5">
		<ul>
			<li>@は不要</li>
		</ul>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::input('color', Session::get_flash('color', $data['color']), ['class' => 'input validate']); ?>
		<label for="form_email" data-error="好きな駒の色の形式が正しくありません">好きな駒の色(任意)</label>
	</div>
	<div class="input-field col s12">
		<?= Form::input('favorite_occupations', Session::get_flash('favorite_occupations', $data['favorite_occupations']), ['class' => 'input validate']); ?>
		<label for="form_email" data-error="好きな職業の形式が正しくありません">好きな職業(任意)</label>
	</div>
	<div class="input-field col s12">
		<?= Form::input('favorite_improvements', Session::get_flash('favorite_improvements', $data['favorite_improvements']), ['class' => 'input validate']); ?>
		<label for="form_email" data-error="好きな進歩の形式が正しくありません">好きな進歩(任意)</label>
	</div>
	<div class="input-field col s12 m7">
		<?= Form::textarea('comments', Session::get_flash('comments', $data['comments']), ['class' => 'materialize-textarea validate']); ?>
		<label for="form_email" data-error="ひとことの形式が正しくありません">ひとこと(任意)</label>
	</div>
	<div class="col s12">
		<?= Form::submit('submit', '確認', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>