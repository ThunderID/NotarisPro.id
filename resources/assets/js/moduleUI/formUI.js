; window.formUI = {
	disableEnter : function () {
		$('body').on('keydown', 'form', function (e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				return false;
			}
		});
	}
}