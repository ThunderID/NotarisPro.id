;window.selectUI = {
	selectTag: function () {
		$('.select-tag').select2({
			themes: 'bootstrap',
			tokenSeparators: [',', ' '],
		});
	},
	init: function() {
		window.selectUI.selectTag();
	}
}