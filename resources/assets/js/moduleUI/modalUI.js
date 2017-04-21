;window.modalUI = {
	init: function () {
		$('body').on('shown.bs.modal', '#list-widgets', function(el) {
			field = $(el.relatedTarget).attr('data-widget');
			$(this).find('*[data-save=true]').attr('data-parsing', field);
			$(this).find('input').attr('name', field);
			window.widgetEditorUI.checkContentWidget(field);
		});
		window.modalUI.resetInputDefault();
	},
	resetInputDefault: function () {
		$('body').on('hidden.bs.modal', '.modal', function(el) {
			$('input').val('');
			$(this).find('*[data-save=true]').attr('data-parsing', '');
		});
	}
}