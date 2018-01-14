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
			<dt class="green-text text-darken-1">表示名</dt>
			<dd><?= $data['screen_name']; ?></dd>
			<?php if ($data['twitter_id'] !== ''): ?>
			<dt class="green-text text-darken-1">Twitter ID</dt>
			<dd><?= $data['twitter_id']; ?></dd>
			<?php endif; ?>
			<?php if ($data['color'] !== ''): ?>
			<dt class="green-text text-darken-1">好きな駒の色</dt>
			<dd><?= $data['color']; ?></dd>
			<?php endif; ?>
			<?php if ($data['favorite_occupations'] !== ''): ?>
			<dt class="green-text text-darken-1">好きな職業</dt>
			<dd><?= $data['favorite_occupations']; ?></dd>
			<?php endif; ?>
			<?php if ($data['favorite_improvements'] !== ''): ?>
			<dt class="green-text text-darken-1">好きな進歩</dt>
			<dd><?= $data['favorite_improvements']; ?></dd>
			<?php endif; ?>
			<?php if ($data['comments'] !== ''): ?>
			<dt class="green-text text-darken-1">ひとこと</dt>
			<dd><?= nl2br($data['comments']); ?></dd>
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