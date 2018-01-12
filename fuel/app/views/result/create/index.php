<h1 class="orange-text text-darken-1">ゲーム作成</h1>
<?php if (isset($error)): ?>
<h2 class="red-text">エラー</h2>
<?= Html::ul((array) $error, ['class' => 'red-text']); ?>
<?php endif; ?>
<?= Form::open(); ?>
<div class="row">
	<div class="col s12 m6 input-field">
		<?= Form::select('player_num', Input::post('player_num'), $player_num_list); ?>
		<label for="form_player_num">人数</label>
	</div>
	<div class="col s12 m6 input-field">
		<?= Form::select('regulation', Input::post('regulation'), $regulation_list); ?>
		<label for="form_regulation">レギュレーション</label>
	</div>
	<div class="col s12 m6 input-field">
		<?= Form::input('player[]', Input::post('player.0'), ['id' => 'form_player_1']); ?>
		<label for="form_player_1">プレイヤーID(1番手)</label>
	</div>
	<div class="col s12 m6 input-field">
		<?= Form::input('player[]', Input::post('player.1'), ['id' => 'form_player_2']); ?>
		<label for="form_player_2">プレイヤーID(2番手)</label>
	</div>
	<div class="col s12 m6 input-field">
		<?= Form::input('player[]', Input::post('player.2'), ['id' => 'form_player_3']); ?>
		<label for="form_player_3">プレイヤーID(3番手)</label>
	</div>
	<div class="col s12 m6 input-field">
		<?= Form::input('player[]', Input::post('player.3'), ['id' => 'form_player_4']); ?>
		<label for="form_player_4">プレイヤーID(4番手)</label>
	</div>
	<div class="col s12 m6 input-field">
		<?= Form::input('player[]', Input::post('player.4'), ['id' => 'form_player_5']); ?>
		<label for="form_player_5">プレイヤーID(5番手)</label>
	</div>
	<div class="col s12 input-field">
		<?= Form::submit('submit', '作成', ['class' => 'btn green']); ?>
	</div>
</div>
<?= Form::csrf(); ?>
<?= Form::close(); ?>
