$(document).ready(function() {
	$('select').material_select();
    for (var i = 1; i <= 5; i++) {
        $('#form_player_' + i).prop('disabled', true);
    }
	$.ajax({
        type: "GET",
        url: "/api/users/list.json",
        dataType: "json",
    }).then(function(data) {
    	var list = {};
    	for (let record of data) {
    		list[record.user_id] = '/assets/img/' + record.icon;
    	}
        $('input').autocomplete({
			data: list,
			limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
			onAutocomplete: function(val) {
			// Callback function when value is autcompleted.
			},
			minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
		});
    });
    $('#form_player_num').change(function() {
        var player_num = $('#form_player_num').val();
        for (var i = 1; i <= 5; i++) {
            if (i > player_num) {
                $('#form_player_' + i).prop('disabled', true);
            } else {
                $('#form_player_' + i).prop('disabled', false);
            }
        }
    });
});
