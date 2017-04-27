;window.editorUI = {
	renderListMention: function (data, callBack) {
		list = '';

		var count = 1;
		for (var i in data) {
			link = "<a href='#' class='dropdown-item link-mention' role='option'>" +data[i]+ "</a>";
			list += link;
			if (count < Object.keys(data).length) {
				list += "<div class='dropdown-divider m-0'></div>"; 
			}
			count++;
		}
		return list;
	},
	searchMention: function (param) {
		var search = param.toLowerCase().substr(1);
		var result = {};

		try {
			for (var i in dataListWidgets) {
				if (i.toLowerCase().indexOf(search) > -1) {
					result[i] = dataListWidgets[i];
				}
			}
		} catch (err) {
			result['no_result'] = 'No Result';
		}

		return result;
	},
	autoSave: function (el, url, form) {
		var triggerAutoSave = function (event, editable) {
			$.ajax({
				url: url,
				type: 'POST',
				data: form.serialize(),
				success: function (data){

				}
			});
		};

		var throttledAutoSave = window.Editor.util.throttle(triggerAutoSave, 3000);
		el.subscribe('editableInput', function(event, editable) {
			console.log('tes');
		});

	},
	init: function (url, form) {
		var editor = new window.Editor(".editor", {
	    	// button on toolbar medium-editor
			toolbar: {
				buttons: ["bold", "italic", "underline", "justifyLeft", "justifyCenter", "justifyRight", "orderedlist", "unorderedlist", "indent", "outdent"]
			},
			placeholder: {
				text: "Tulis disini",
				hideOnClick: true,
			},
			buttonLabels: "fontawesome",
			paste: {
				cleanPastedHTML: true,
				forcePlainText: false,
			},
			spellcheck: false,
			disableExtraSpaces: true,
			targetBlank: true,
			extensions: {
				mention: new window.Mention({
					extraPanelClassName: 'dropdown-menu',
					tagName: 'span',
					renderPanelContent: function (panelEl, currentMentionText, selectMentionCallback) {
						this.mention = window.editorUI.searchMention(currentMentionText);
						if ([this.mention].length != 0) {
							listMention = window.editorUI.renderListMention(this.mention, selectMentionCallback);
							$(panelEl).attr('role', 'menu').css('display', 'block').addClass('menu-mention text-left m-0 p-0');
							$(panelEl).html(listMention);
						}
						$('.link-mention').on('click', function(el) {
							el.preventDefault();
							selectMentionCallback($(this).html());
						});
						$('span.medium-editor-mention-at').addClass('text-danger');
					},
					activeTriggerList: ["@"],
				})
			}
		});

		window.editorUI.autoSave(editor, url, form);
		// try {
		// 	if ((typeof (url) != 'undefined') || (typeof (form) != 'undefined' )) {
		// 	}
		// }
		// catch (err) {
		// 	console.log('data tidak tersimpan secara otomatis');
		// }
	}
}