<h1 class="orange-text text-darken-2">確認ページ</h1>
<p>
	以下の情報が正しいか確認し、「登録」ボタンを押してください。
</p>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<div class="row">
	<div class="col s12">
		<dl>
			<dt class="green-text text-darken-1">ID</dt>
			<dd><?= $data['username']; ?></dd>
			<dt class="green-text text-darken-1">表示名</dt>
			<dd><?= $data['screen_name']; ?></dd>
			<dt class="green-text text-darken-1">メールアドレス</dt>
			<dd><?= $data['email']; ?></dd>
		</dl>
	</div>
	<div class="col s12">
		<?= Form::submit('return', '戻る', ['class' => 'btn grey']); ?>
		<?= Form::submit('submit', '登録', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>