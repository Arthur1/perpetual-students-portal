<h1 class="orange-text text-darken-1">初手ピックシミュレーター</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<p>以下のボタンを押すと、リダイレクトして7枚ずつカードをピックします。リダイレクト先のURLを共有することで同じ手札を再現できます。</p>
<?= Form::submit('submit', '手札を作成する', ['class' => 'btn green']); ?>
<?= Form::csrf(); ?>
<?= Form::close(); ?>
