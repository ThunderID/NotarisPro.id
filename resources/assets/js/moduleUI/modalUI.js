;window.modalUI = {
	init: function () {
		window.modalUI.listWidgets();
	},
	listWidgets: function ()  {
		$('body').on('shown.bs.modal', '#list-widgets', function(el) {
			field = $(el.relatedTarget).attr('data-widget');
			$(this).find('*[data-save=true]').attr('data-parsing', field);
			$(this).find('input').attr('name', field);
			window.widgetEditorUI.checkContentWidget(field);
			window.modalUI.changeNameModal($(this), 'Form ' + field.replace('@', '').replace('.', ' ').replace('_', ' '));
		});
		window.modalUI.resetInputDefault();
	},
	resetInputDefault: function () {
		$('body').on('hidden.bs.modal', '.modal', function(el) {
			$(this).find('input').val('');
			$(this).find('*[data-save=true]').attr('data-parsing', '');
		});
	},
	changeNameModal: function (el, param) {
		el.find('.modal-title').html(window.typographyUI.ucwords(param));
	}
}