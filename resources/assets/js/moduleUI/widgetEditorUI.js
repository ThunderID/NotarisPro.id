; window.widgetEditorUI = {
	init: function () {
		$('.modal').on('click', "button[data-save=true]" , function(e) {
			e.preventDefault();
			field = $(this).attr('data-parsing');
			value = $('#list-widgets').find('input').val();
			
			window.widgetEditorUI.replaceContentWithData(field, value);
			window.widgetEditorUI.isActive(field);
			$('#list-widgets').modal('hide');
			// $('.editor').find(field).replace(field, value);
		});
	},
	replaceContentWithData: function (param, data) {
		mention = $('div.editor').find('b.medium-editor-mention-at');
		$.each(mention, function(k, v) {
			if (($(v).html() == param) || ($(v).attr('data-content') == param)) {
				$(v).attr('data-content', param);
				$(v).html(data);
			}
		});
	},
	checkContentWidget: function (param) {
		listMention = $('div.editor').find('b.medium-editor-mention-at');
		$.each(listMention, function(k, v) {
			dataContent  = $(v).attr('data-content');
			if (($(v).html() == param) || ($(v).attr('data-content') == param)) {
				if (typeof ($(v).attr('data-content')) != 'undefined') {
					$('#list-widgets').find('input').val($(v).html());
				}
				
			}
		});
	},
	isActive: function (param) {
		list = $('.list-widgets').find('*[data-widget="' +param+ '"]');
		list.find('span').addClass('active');
	},
}