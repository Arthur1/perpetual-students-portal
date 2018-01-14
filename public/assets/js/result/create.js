$(document).ready(function() {
	$('select').material_select();
	$.ajax({
        type: "GET",
        url: "/api/users/list.json",
        dataType: "json",
    }).then(function(data) {
    	var list = {};
    	for (let record of data) {
    		list[record.user_id] = '/assets/img/upload/profile/' + record.icon;
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
});
