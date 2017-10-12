/**
 * [ArsipList description]
 * function to get data list & set list to display
 * @param: link url
 * 
 */
window.ArsipList = {
	getData: function (url, selectList) {
		let ajxArsip = window.ajax;

		ajxArsip.defineOnSuccess(function(respon) {
			window.ArsipList.setList(respon, selectList);
		});

		ajxArsip.defineOnError( function(respon) {
			console.log(respon);
		})

		ajxArsip.get(url);
	},
	setList: function (data, container) {
		$.map(data, function(v, i) {
			var option = $("<option></option>");

			option.val(v._id)
				.html(v._id + ' - ' + v.pemilik.nama)
				.attr('data-list', '{' + v.lists + '}')
				.attr('data-name', v.pemilik.nama);
			
			$(container).append(option);
		});
	},
	getDataDokumen: function (url) {
		let ajxDokumen = window.ajax;

		ajxDokumen.defineOnSuccess( function(respon) {
			$('.content-data-dokumen').html('');
			$.map(respon, function(v, i) {
				let $formGroup = $('<div class="form-group"></div>');
				let title = i.split('.');
				let field = title[title.length - 1].replace('@', '');

				if (field == 'nama') {
					$formGroup.append('<label class="text-uppercase">' + field.replace('_', ' ') + '</label>')
						.append('<input class="form-control" name="'+ field +'" value="'+ v +'" />');
				} else if (field !== '_token') {
					$formGroup.append('<label class="text-uppercase">' + field.replace('_', ' ') + '</label>')
						.append('<input class="form-control" name="'+ field +'" value="'+ v +'" />');
				}
				$('.content-data-dokumen').append($formGroup);
			});
			$('.content-data-dokumen').append('<input type="hidden" name="jenis" value="ktp" />');
		});

		ajxDokumen.defineOnError( function(respon) {

		});

		ajxDokumen.get(url);
	},
	init: function (param, container) {
		this.getData(param, container);
	}
}