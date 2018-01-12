$(function(){
	$('#calc_btn').on('click', function() {
		const fields = [
			'fields',
			'pastures',
			'grain',
			'vegetable',
			'sheep',
			'boars',
			'cattle',
			'horses',
			'unused_spaces',
			'stables',
			'houses',
			'family',
			'begging',
			'card_points',
			'bonus_points'
		];
		score = 0;
		for (const field of fields) {
			score += Number($('#form_' + field).val());
		}
		$('#form_total_score').val(score);
	});
	$('#occupations_btn').on('click', function() {
		$('#occupations_btn_box').before('<div class="col s4 m3 l2 input-field"><input class="input validate" name="occupations[]" value="" type="text" id="form_occupations[]"><label for="form_occupations[]" data-error="値が正しくありません">職業</label></div>');
	});
	$('#minor_improvements_btn').on('click', function() {
		$('#minor_improvements_btn_box').before('<div class="col s4 m3 l2 input-field"><input class="input validate" name="minor_improvements[]" value="" type="text" id="form_minor_improvements[]"><label for="form_total_score" data-error="値が正しくありません">小さい進歩</label></div>');
	});
	$('#major_improvements_btn').on('click', function() {
		$('#major_improvements_btn_box').before('<div class="col s4 m3 l2 input-field"><input class="input validate" name="major_improvements[]" value="" type="text" id="form_major_improvements[]"><label for="form_total_score" data-error="値が正しくありません">大きい進歩</label></div>');
	});
});