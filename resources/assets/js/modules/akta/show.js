window.aktaShow = {
	pageShow: function () {

	},
	pageHide: function () {

	},
	getData: function (url) {
		let ajaxAkta = window.ajax;

		ajaxAkta.defineOnSuccess(function(respon) {
			// event for ajax success
			try {
				// reloaded from index
				// set sidebar right
				// 
			} catch (err) {
				// catch if data error
				$('.show-before-load').hide();
				$('.show-on-error').show();
				$(document.getElementById('loader-error-code')).text('422');
			}
		});

		ajaxAkta.defineOnError(function(respon) {
			console.log(respon);
			// event for ajax error
			$('.show-before-load').hide();
			$('.show-on-error').show();
			$(document.getElementById('loader-error-code')).text(respon.status);
		});

		ajaxAkta.get(url);
	},
	init: function (urlShow) {
		
		window.aktaShow.getData(urlShow);
	}
}