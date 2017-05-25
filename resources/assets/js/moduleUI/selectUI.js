import $ from 'jquery';
;window.selectUI = {
	selectMultiple: function () {
		$('.select-multiple').select2({
			tokenSeparators: [',', ' '],
		});
	},
	selectTag: function () {
		$('.select-tag').select2({
			tokenSeparators: [',', ' '],
			tags: true,
		});
	},
	init: function() {
		this.selectTag();
		this.selectMultiple();
	}
}