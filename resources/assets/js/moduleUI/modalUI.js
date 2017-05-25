;window.modalUI = {
	listWidgets: function ()  {
		$('#fill-mention').on('show.bs.modal', function(el) {
			field = $(el.relatedTarget).attr('data-widget');

			$(this).find('*[data-save=true]').attr('data-parsing', field);
			$(this).find('input').attr('name', field);

			if (field.indexOf('tanggal') !== -1) {
				$(this).find('input').addClass('mask-date');
				var date = new Inputmask('datetime', {
					mask: "1-2-y", 
					placeholder: "dd-mm-yyyy",  
					separator: "-", 
					alias: "dd/mm/yyyy"
				});
				date.mask($('.mask-date'));
			}

			window.widgetEditorUI.checkContentWidget(field);
			window.modalUI.changeNameModal($(this), 'Form ' + field.replace('@', '').replace(/\./g, ' ').replace(/_/i, ' '));
		});
	},
	resetInputDefault: function () {
		$('body').on('hidden.bs.modal', '.modal', function(el) {
			inputElement = $(this).find('input');
			inputElement.val('');

			if (inputElement.hasClass('mask-date')) {
				Inputmask.remove(inputElement);
			}

			$(this).find('*[data-save=true]').attr('data-parsing', '');
		});
	},
	changeNameModal: function (el, param) {
		el.find('.modal-title').html(window.typographyUI.ucwords(param));
	},
	init: function () {
		window.modalUI.listWidgets();
		window.modalUI.resetInputDefault();
	},
}