; window.formUI = {
	disableEnter : function () {
		$('body').on('keydown', 'form', function (e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				return false;
			}
		});
	},
	setFocus : function () {
		$('.set-focus').focus();
	},
	init : function () {
		window.formUI.setFocus();
		window.formUI.disableEnter();
	}
}