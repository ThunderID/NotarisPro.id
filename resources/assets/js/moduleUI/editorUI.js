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
			loadingAnimation.changeColor('#ddd');
			loadingAnimation.loadingStart();
			$('.save-content').html('<i class="fa fa-circle-o-notch fa-spin"></i> Auto Simpan..').addClass('disabled');
			$('.save-as-content').html('<i class="fa fa-circle-o-notch fa-spin"></i> Auto Simpan..').addClass('disabled');
			/* function ajax required url, type method, data */
			window.ajaxCall.withoutSuccess(url, 'POST', form.serialize());
			setTimeout( function (){
				loadingAnimation.loadingStop();
				$('.save-content').html('<i class="fa fa-save"></i> Simpan').removeClass('disabled');
				$('.save-as-content').html('<i class="fa fa-save"></i> Simpan Sebagai').removeClass('disabled');
			}, 2000);
		};

		var throttledAutoSave = window.Editor.util.throttle(triggerAutoSave, 5000);
		el.subscribe('editableInput', throttledAutoSave);
	},
	init: function (url, form) {
		var editor = new window.Editor("textarea.editor", {
			// button on toolbar medium-editor
			toolbar: {
				buttons: [{name: 'h4', contentFA: '<i class="fa fa-header"></i>1'}, {name: 'h5', contentFA: '<i class="fa fa-header"></i>2'},
					"bold", "italic", "underline", "justifyLeft", "justifyCenter", "justifyRight", "orderedlist", "unorderedlist", "indent", "outdent"
				],
				static: true,
				sticky: true,
				diffLeft: 0,
		        diffTop: -330,
		        updateOnEmptySelection: true
			},
			onHideToolbar: function () {
				// editor.toolbar.showToolbar();
			},
			placeholder: {
				text: "Tulis disini",
				hideOnClick: true,
			},
			buttonLabels: "fontawesome",
			paste: {
				cleanPastedHTML: false,
				forcePlainText: true,
			},
			spellcheck: false,
			disableExtraSpaces: false,
			targetBlank: true,
			// disableEditing: true,
			extensions: {
				mention: new window.Mention({
					extraPanelClassName: 'dropdown-menu',
					tagName: 'span',
					renderPanelContent: function (panelEl, currentMentionText, selectMentionCallback) {
						this.mention = window.editorUI.searchMention(currentMentionText);
						console.log(this.mention);
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

		// in input able remove color and style color
		editor.subscribe('editableInput', function (event, editable) {
			$(editable).children().each( function(k, v){
				$(this).css('color', '');
				$(this).find('*').removeAttr('color').css('color', '');
			});
		});


		try {
			window.editorUI.autoSave(editor, url, form);
		}
		catch (err) {
			console.log('data tidak tersimpan secara otomatis');
		}
	}
}