; window.widgetEditorUI = {
	init: function () {
		$('.modal').on('click', "button[data-save=true]" , function(e) {
			e.preventDefault();
			field = $(this).attr('data-parsing');
			value = $('#list-widgets').find('input').val();
			
			window.widgetEditorUI.replaceContentWithData(field, value);

			$.ajax({
				url: urlFillMention,
				type: 'POST',
				data: {mention: field, isi_mention: value},
				dataType: 'json',
				success: function (data) {
					console.log(data);
					// return data;
				}
			});

			window.widgetEditorUI.isActive(field);

			$('#list-widgets').modal('hide');
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