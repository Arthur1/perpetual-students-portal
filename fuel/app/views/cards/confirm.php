<h1 class="orange-text text-darken-2">確認ページ</h1>
<p>
	以下の情報が正しいか確認し、「送信」ボタンを押してください。
</p>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<div class="row">
	<div class="col s12">
		<dl>
			<dt class="green-text text-darken-1">カード番号</dt>
			<dd><?= $data['card_id']; ?></dd>
			<dt class="green-text text-darken-1">評価点</dt>
			<dd><?= $data['points']; ?>点</dd>
			<?php if ($data['opinion'] !== ''): ?>
			<dt class="green-text text-darken-1">ひとこと</dt>
			<dd><?= nl2br($data['opinion']); ?></dd>
			<?php endif; ?>
		</dl>
	</div>
	<div class="col s12">
		<?= Form::submit('return', '戻る', ['class' => 'btn grey']); ?>
		<?= Form::submit('submit', '送信', ['class' => 'btn green']); ?>
	</div>
</div>

<?= Form::csrf(); ?>

<?= Form::close(); ?>