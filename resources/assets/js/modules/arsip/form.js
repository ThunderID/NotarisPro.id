window.formArsip = {
	dataForm: null,
	update: function (url) {
		let ajxFormArsip = window.ajax;

		ajxFormArsip.defineOnSuccess(function(respon) {
			// hasil ketika update arsip success
			console.log(respon);
		});

		ajxFormArsip.defineOnError(function(respon) {
			// hasil ketika update arsip gagal
		});

		ajxFormArsip.post(url, window.formArsip.dataForm);
	},
	store: function () {

	},
	getInput: function (container) {
		var formData = new FormData();

		container.each(function (i, v) {
			if ($(v).attr('name') === 'nama') {
				formData.append('dokumen['+ $(v).attr('name') +']', $(v).val());
				formData.append('pemilik['+ $(v).attr('name') +']', $(v).val());
			} else if ($(v).attr('name') !== '_token') {
				formData.append('dokumen['+ $(v).attr('name') +']', $(v).val());
			}
		});
		window.formArsip.dataForm = formData;
	},
	init: function () {
		$(document).on('submit', '#form-arsip', function(e) {
			e.preventDefault();

			let $form = $(this);
			let url = $form.attr('data-action');

			window.formArsip.getInput($form.find('input'));
			window.formArsip.update(url);
			window.ModuleModal.modalHide('#choose-data-modal');
		});
	}
}