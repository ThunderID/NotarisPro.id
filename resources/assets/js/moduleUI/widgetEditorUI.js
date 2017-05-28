; window.widgetEditorUI = {
	init: function (url) {
		$('.modal').on('click', "button[data-save=true]" , function(e) {
			e.preventDefault();
			field 			= $(this).attr('data-parsing');
			value 			= $('#fill-mention').find('input').val();
			isi_template  	= $('#doc-content-mention').val();
			
			window.widgetEditorUI.replaceContentWithData(field, value);

			loadingAnimation.changeColor('#ddd');
			loadingAnimation.loadingStart();
			$('.save-content').html('<i class="fa fa-circle-o-notch fa-spin"></i> Auto Simpan..').addClass('disabled');

			// call ajax add fill mention
			/* function ajax required url, type method, data */
			window.ajaxCall.withoutSuccess(url, 'POST', {mention: field, isi_mention: value, template: isi_template});

			setTimeout( function (){
				loadingAnimation.loadingStop();
				$('.save-content').html('<i class="fa fa-save"></i> Simpan').removeClass('disabled');
			}, 2000);

			window.widgetEditorUI.isActive(field);

			$('#fill-mention').modal('hide');
		});
	},
	replaceContentWithData: function (param, data) {
		mention = $('div.editor').find('span.medium-editor-mention-at');
		$.each(mention, function(k, v) {
			if (($(v).html() == param) | ($(v).attr('data-mention') == param)) {
				$(v).attr('data-mention', param);
				$(v).attr('data-value', data);
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