$(document).ready(function() {
	$('select').material_select();
	$('input').autocomplete({
		data: {
			"Arthur": 'https://pbs.twimg.com/profile_images/936629123765567488/yhndhwmr_400x400.jpg',
			"Linker": null,
			"Guest": null
		},
		limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
		onAutocomplete: function(val) {
		// Callback function when value is autcompleted.
		},
		minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
	});
});
