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
				if (dataListWidgets[i].toLowerCase().substr(1).indexOf(search) > -1) {
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
	
	init: function (url, form, param) {
		// init: function () {
		// 	window.Editor.Extension.prototype.init.apply(this, arguments);

		//     this.initThrottledMethods();
		//     var newToolbar = $(this.getToolbarElement());
		//     // newToolbar.find('#medium-editor-toolbar-1').remove();
		//     // console.log($(this.getToolbarElement()).find('#medium-editor-toolbar-1').removeAttr('style'));
		//     $('#toolbarMedium').append(newToolbar);
		//     $('#toolbarMedium').find('.medium-editor-toolbar').attr('data-hes', 'halo');
		//     // $('#toolbarMedium').find('.medium')
		//     // $('#toolbarMedium').find('#medium-editor-toolbar-1').attr('style', '');
		//     // this.getEditorOption('#toolbarMediume').appendChild(this.getToolbarElement());
		// },
		// hideToolbar: function () {

		// }
		var editor = new window.Editor("textarea.editor", {
			// button on toolbar medium-editor
			toolbar: {
				buttons: [{name: 'h4', contentFA: '<i class="fa fa-header" style="font-size: 15px;"></i>'}, {name: 'h5', contentFA: '<i class="fa fa-header" style="font-size: 10px;"></i>'},
					"bold", "italic", "underline", "justifyLeft", "justifyCenter", "justifyRight", "orderedlist", "unorderedlist", "indent", "outdent"
				],
				// static: true,
				// updateOnEmptySelection: true,
				// sticky: true,
			},
			// toolbar: false,
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
			extensions: {
				mention: new window.Mention({
					extraPanelClassName: 'dropdown-menu',
					tagName: 'span',
					renderPanelContent: function (panelEl, currentMentionText, selectMentionCallback) {
						this.mention = window.editorUI.searchMention(currentMentionText);
						if (Object.keys(this.mention).length != 0) {
							listMention = window.editorUI.renderListMention(this.mention, selectMentionCallback);
							$(panelEl).attr('role', 'menu').css('display', 'block').css('height', '200px').css('overflow-y', 'scroll').addClass('menu-mention text-left m-0 p-0');
							$(panelEl).html(listMention);
						}
						else {
							fieldMention = currentMentionText.substr(1);
							listMention = window.editorUI.renderListMention({fieldMention: currentMentionText}, selectMentionCallback);
							$(panelEl).attr('role', 'menu').css('display', 'block').addClass('menu-mention text-left m-0 p-0');
							$(panelEl).html(listMention);
						}
						$('.link-mention').on('click', function(el) {
							el.preventDefault();
							if ($(this).html() === currentMentionText) {
								selectMentionCallback(null);
							} else {
								selectMentionCallback($(this).html());
							}
						});
						$('span.medium-editor-mention-at').addClass('text-danger').removeClass('medium-editor-mention-at-active');
					},
					destroyPanelContent: function (panelEl) {
						$(panelEl).remove();
					},
					activeTriggerList: ["@"],
				}),
			}
		});

		// in input able remove color and style color
		editor.elements.forEach(function (element) {
			$(element).find('*').removeAttr('color').css('color', '');
			$(element).find('span').each(function (k, v) {
				if ($(v).hasClass('medium-editor-mention-at')) {
					text = $(v).html();
					if (text.charAt(0) != '@') {
						$(v).removeClass('medium-editor-mention-at medium-editor-mention-at-active text-danger text-primary');
					}
				}
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