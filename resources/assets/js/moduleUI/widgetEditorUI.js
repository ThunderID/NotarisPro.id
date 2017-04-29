; window.widgetEditorUI = {
	init: function () {
		$('.modal').on('click', "button[data-save=true]" , function(e) {
			e.preventDefault();
			field 			= $(this).attr('data-parsing');
			value 			= $('#list-widgets').find('input').val();
			isi_template  	= document.getElementById("doc-content-mention").value;
			
			window.widgetEditorUI.replaceContentWithData(field, value);

			// call ajax add fill mention
			/* function ajax required url, type method, data */
			window.ajaxCall.withoutSuccess(urlFillMention, 'POST', {mention: field, isi_mention: value, template: isi_template});

			window.widgetEditorUI.isActive(field);

			$('#list-widgets').modal('hide');

			// call ajax auto save editor
			/* function ajax required url, type method, data */
			window.ajaxCall.withoutSuccess(urlAutoSave, 'POST', form.serialize());
		});
	},
	replaceContentWithData: function (param, data) {
		mention = $('div.editor').find('span.medium-editor-mention-at');
		$.each(mention, function(k, v) {
			if (($(v).html() == param) || ($(v).attr('data-mention') == param)) {
				$(v).attr('data-mention', param);
				$(v).removeClass('text-danger').addClass('text-primary');
				$(v).html(data);
			}
		});
		$('textarea.editor').html($('.editor').html());
	},
	checkContentWidget: function (param) {
		listMention = $('div.editor').find('span.medium-editor-mention-at');
		$.each(listMention, function(k, v) {
			dataContent  = $(v).attr('data-mention');
			if (($(v).html() == param) || ($(v).attr('data-mention') == param)) {
				if (typeof ($(v).attr('data-mention')) != 'undefined') {
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