import $ from 'jquery';
import 'jquery.caret';
import 'at.js';

window.editorUI = {
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
	quill: function () {
		var currentCursor, newIndex, suffix, textSearch;
		var selector = document.getElementById('editor');
		var toolbarOptions = [
			['bold', 'italic', 'underline'],
			[{ 'list': 'ordered'}, { 'list': 'bullet' }],
			[{ 'script': 'sub'}, { 'script': 'super' }],
			[{ 'indent': '-1'}, { 'indent': '+1' }],
			[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
			[{ 'align': [] }],
			['clean'],
			['openData']
		];
		var options = {
			placeholder: 'Tulis disini',
			theme: 'snow',
			modules: {
				// toolbar: toolbarOptions
				toolbar: '#toolbarPane'
			}
		};

		var editor = new window.Quill('#editor', options);
		var toolbar = editor.getModule('toolbar');
		toolbar.addHandler('openData', function() {});

		var buttonOpenData = document.querySelector('.ql-openData');
		buttonOpenData.addEventListener('click', function() {
			var flag = buttonOpenData.getAttribute('data-flag');
			if (flag == 'close') {
				$('#DataList').css('display', 'block');
				buttonOpenData.setAttribute('data-flag', 'open');
			} else {
				$('#DataList').css('display', 'hide');
				buttonOpenData.setAttribute('data-flag', 'close');
			}
		});

		// Data Mention
		editor.on('text-change', function() {
			let range = editor.getSelection();
			if (range) {
				if (range.length == 0) {
					currentCursor = range.index;
				} else {
					currentCursor = range.index;
				}
			}
		});

		$('#editor').on('matched.atwho', function(event, flag, query) {
			suffix = flag;
			textSearch = query;
		});

		if (listMention) {
			const config = {
				at: "@",
				data: listMention,
				functionOverrides: {
					insert: function (text) {
						let cursor = currentCursor;

						if ((typeof(suffix) != 'undefined') && (typeof(textSearch) != 'undefined')) {
							var newIndex = parseInt(cursor + text.length);

							editor.insertText(cursor, text, Quill.sources.USER);
							editor.deleteText((cursor - (suffix.length + textSearch.length)), (suffix.length + textSearch.length));
							editor.deleteText(newIndex, 1);
							editor.setSelection(newIndex, 0);
						}					
					}
				}
			};
			$(editor.root).atwho(config);
		}

		$('.data-mention').on('click', function(e) {
			e.preventDefault();
			var textValue = $(this).attr('data-value');

			// set selection
			var range = editor.getSelection();
			if (range) {
				if (range.length == 0) {
					console.log('User cursor is at index', range.index);
					editor.insertText(range.index, textValue, '', true);
				} else {
					var text = editor.getText(range.index, range.length);
					editor.deleteText(range.index, range.length);
					editor.insertText(range.index, textValue, '', true);
					console.log('User has highlighted: ', text);
				}
			} else {
				editor.insertText(editor.getLength() - 1, textValue, '', true);
				console.log('User cursor is not in editor');
			}
		});
	},
	init: function () {
		// var editor = new window.Editor("textarea.editor", {
		// 	// button on toolbar medium-editor
		// 	toolbar: {
		// 		buttons: [{name: 'h4', contentFA: '<i class="fa fa-header" style="font-size: 15px;"></i>'}, {name: 'h5', contentFA: '<i class="fa fa-header" style="font-size: 10px;"></i>'},
		// 			"bold", "italic", "underline", "justifyLeft", "justifyCenter", "justifyRight", "orderedlist", "unorderedlist", "indent", "outdent"
		// 		],
		// 		// static: true,
		// 		// updateOnEmptySelection: true,
		// 		// sticky: true,
		// 	},
		// 	// toolbar: false,
		// 	placeholder: {
		// 		text: "Tulis disini",
		// 		hideOnClick: true,
		// 	},
		// 	buttonLabels: "fontawesome",
		// 	paste: {
		// 		cleanPastedHTML: false,
		// 		forcePlainText: true,
		// 	},
		// 	spellcheck: false,
		// 	disableExtraSpaces: false,
		// 	extensions: {
		// 		mention: new window.Mention({
		// 			extraPanelClassName: 'dropdown-menu',
		// 			tagName: 'span',
		// 			renderPanelContent: function (panelEl, currentMentionText, selectMentionCallback) {
		// 				this.mention = window.editorUI.searchMention(currentMentionText);
		// 				if (Object.keys(this.mention).length != 0) {
		// 					listMention = window.editorUI.renderListMention(this.mention, selectMentionCallback);
		// 					$(panelEl).attr('role', 'menu').css('display', 'block').css('height', '200px').css('overflow-y', 'scroll').addClass('menu-mention text-left m-0 p-0');
		// 					$(panelEl).html(listMention);
		// 				}
		// 				else {
		// 					fieldMention = currentMentionText.substr(1);
		// 					listMention = window.editorUI.renderListMention({fieldMention: currentMentionText}, selectMentionCallback);
		// 					$(panelEl).attr('role', 'menu').css('display', 'block').addClass('menu-mention text-left m-0 p-0');
		// 					$(panelEl).html(listMention);
		// 				}
		// 				$('.link-mention').on('click', function(el) {
		// 					el.preventDefault();
		// 					if ($(this).html() === currentMentionText) {
		// 						selectMentionCallback(null);
		// 					} else {
		// 						selectMentionCallback($(this).html());
		// 					}
		// 				});
		// 				spanMention = $('span.medium-editor-mention-at');
		// 				spanMention.addClass('text-danger').removeClass('medium-editor-mention-at-active');
		// 			},
		// 			destroyPanelContent: function (panelEl) {
		// 				$(panelEl).remove();
		// 			},
		// 			activeTriggerList: ["@"],
		// 		}),
		// 	}
		// });

		// editor.subscribe('editableInput', function (event, editable) {
		//    $(editable).find('*').each(function (k, v) {

		//    		if ($(v).hasClass('medium-editor-mention-at')) {
		//    			dataValue = $(v).attr('data-value');
		//    			dataMention = $(v).attr('data-mention');
		//    			value = $(v).html();
		   			
		//    			if (typeof dataValue !== 'undefined') {
		//    				$(v).html(dataValue);
		//    			}
		//    		}

		// 		$(v).removeAttr('color', '');
		// 		text = $(v).html();

		// 		if ($(v)[0].style.removeProperty) {
		// 		    $(v)[0].style.removeProperty('color');
		// 		    $(v)[0].style.removeProperty('font-size');
		// 		} else {
		// 		    $(v)[0].style.removeAttribute('color');
		// 		    $(v)[0].style.removeAttribute('font-size');
		// 		}
		// 	});
		// });

		// try {
		// 	window.editorUI.autoSave(editor, url, form);
		// }
		// catch (err) {
		// 	console.log('data tidak tersimpan secara otomatis');
		// }
		window.editorUI.quill();
	}
}