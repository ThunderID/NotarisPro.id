import $ from 'jquery';
import 'jquery.caret';
import 'at.js';

window.editorUI = {
	autoSave: function (editor, textChange) {
		setInterval( function() {
			if (textChange.length() > 0) {
				window.editorUI.postSave(editor);
				return new Delta();
			}
		}, 5*1000);
	},
	postSave: function(editor) {
		let judulAkta 		= $('.form-judul-akta').val();
		let paragrafAkta 	= editor.root.innerHTML;
		let urlStore 		= editor.container.dataset.url;
		let ajaxAkta 		= window.ajax;
		let formData 		= new FormData();
		
		ajaxAkta.defineOnSuccess( function(respon) {
			console.log('success');
			console.log(respon)
		});

		ajaxAkta.defineOnError( function(respon) {
			console.log('gagal');
			console.log(respon)
		});

		formData.append('judul', judulAkta);
		formData.append('jenis', '');
		formData.append('paragraf', paragrafAkta);

		ajaxAkta.post(urlStore, formData);
	},
	parsingArsipMention: function (editor, element) {
		let textValue = element.attr('data-value');
		let textItem = element.attr('data-item');
		let newTextValue = '@' + textValue + textItem + '@';
		let textObj = {text: newTextValue, value: newTextValue};

		// set selection
		var range = editor.getSelection();
		var text = editor.getText(range.index, range.length);
		var newIndex = parseInt(range.index + newTextValue.length);

		if (range) {
			if (range.length == 0) {
				editor.insertEmbed(range.index, 'data-link', textObj);
			} else {
				editor.deleteText(range.index, range.length);
				editor.insertEmbed(range.index, 'data-link', textObj);
			}
		} else {
			editor.insertEmbed(editor.getLength() - 1, 'data-link', textObj);
		}
		editor.setSelection(newIndex, 0)

		// set item show to arsip
		// back to previous item
		$(document.getElementById('arsip-item--two')).removeClass('active');
		setTimeout(function() {
			$(document.getElementById('arsip-item--one')).addClass('active');
		}, 200);

		$(document.getElementById('sidebar-header')).find('#sub-arsip')
			.removeClass('d-flex')
			.hide();
		$(document.getElementById('sidebar-header')).find('#arsip')
			.addClass('d-flex')
			.show();
	},
	panelArsip: function () {
		$(document).on('click', '.btn-arsip-previous', function(e) {
			e.preventDefault();

			$(document.getElementById('arsip-item--two')).removeClass('active');
			setTimeout(function() {
				$(document.getElementById('arsip-item--one')).addClass('active');
			}, 200);

			$(document.getElementById('sidebar-header')).find('#sub-arsip')
				.removeClass('d-flex')
				.hide();
			$(document.getElementById('sidebar-header')).find('#arsip')
				.addClass('d-flex')
				.show();
		});

		// event click for arsip dokumen item
		$(document).on('click', '.dokumen-item', function(e) {
			e.preventDefault();
			let item = $(this).attr('data-item');
			
			$(document.getElementById('arsip-item--one')).removeClass('active');
			$(document.getElementById('arsip-item--two')).find('.arsip-mention')
				.attr('data-item', item);
			$(document.getElementById('arsip-item--two')).find('.add-arsip-prefix')
				.attr('data-item', item);

			// set timeout effect 
			// show arsip child
			setTimeout(function() {
				$(document.getElementById('arsip-item--two')).addClass('active');
			}, 200);


			// toggle sidebar header
			// from arsip to arsip child
			$(document.getElementById('sidebar-header')).find('#arsip')
				.removeClass('d-flex')
				.hide();
			$(document.getElementById('sidebar-header')).find('#sub-arsip')
				.addClass('d-flex')
				.show();
		});
	},
	openPanelArsip: function() {
		$(document).on('click', '.ql-open-arsip', function(e) {
			let flag = $(this).attr('data-flag');

			if (flag == 'close') {
				$('#DataList').addClass('open');
				$(this).attr('data-flag', 'open')
					.addClass('ql-active');
			} else {
				$('#DataList').removeClass('open');
				$(this).attr('data-flag', 'close')
					.removeClass('ql-active');
			}
		});
	},
	closePanelArsip: function () {
		$(document).on('click', '.btn-close-arsip', function() {
			let buttonOpenArsip = $(document.querySelector('.ql-open-arsip'));

			$('#DataList').removeClass('open');
			buttonOpenArsip.attr('data-flag', 'close');
			buttonOpenArsip.removeClass('ql-active');
		});
	},
	quill: function () {
		var currentCursor, newIndex, suffix, textSearch;
		var selector = document.getElementById('editor');
		var Parchment = Quill.import('parchment');
		var Delta = Quill.import('delta');
		var Embed = Quill.import('blots/embed');
		var Break = Quill.import('blots/break');
		var Block = Quill.import('blots/block');

		function lineBreakMatcher() {
			var newDelta = new Delta();
			newDelta.insert({'break': ''});
			return newDelta;
		}

		class SmartBreak extends Break {
			length () {
				return 1;
			}
			value () {
				return '\n';
			}
			insertInto(parent, ref) {
				Embed.prototype.insertInto.call(this, parent, ref);
			}
		}
		SmartBreak.blotName = 'break';
		SmartBreak.tagName = 'BR';

		Quill.register(SmartBreak);

		var options = {
			placeholder: 'Tulis disini',
			theme: 'snow',
			modules: {
				// toolbar: toolbarOptions
				toolbar: '#toolbarPane',
				clipboard: {
					matchers: [
						['BR', lineBreakMatcher] 
					]
				},
				keyboard: {
					bindings: {
						linebreak: {
							key: 13,
							shiftKey: true,
							handler: function (range) {
								let currentLeaf = this.quill.getLeaf(range.index)[0];
								let nextLeaf = this.quill.getLeaf(range.index + 1)[0];

								this.quill.insertEmbed(range.index, 'break', true, 'user');
								// Insert a second break if:
								// At the end of the editor, OR next leaf has a different parent (<p>)
								if (nextLeaf === null || (currentLeaf.parent !== nextLeaf.parent)) {
									this.quill.insertEmbed(range.index, 'break', true, 'user');
								}
								// Now that we've inserted a line break, move the cursor forward
								this.quill.setSelection(range.index + 1, Quill.sources.SILENT);
							}
						}
					}
				}
			}
		};

		var changeText = new Delta();
		var editor = new window.Quill('#editor', options);
		var toolbar = editor.getModule('toolbar');
		
		var buttonNewDocument = document.querySelector('.ql-new');
		var buttonSaveDocument = document.querySelector('.ql-save');

		var length = editor.getLength();
		var text = editor.getText(length - 2, 2);

		// Remove extraneous new lines
		if (text === '\n\n') {
			editor.deleteText(editor.getLength() - 2, 2);
		}

		class dataMention extends Embed {
			static create (value) {
				let node = super.create(value);

				node.setAttribute('style', 'color: #0275d8');
				node.setAttribute('data-mention', value.value);
				node.innerHTML = value.text;

				return node;
			}
		}

		dataMention.blotName = 'data-link';
		dataMention.className = 'data-link';
		dataMention.tagName = 'span';

		Quill.register({
			'formats/data-link': dataMention
		});

		// function on click button new 
		// editor
		buttonNewDocument.addEventListener('click', function(e) {
			console.log('new document');
		});

		// function on click button save
		// from editor
		buttonSaveDocument.addEventListener('click', function(e) {
			e.preventDefault();
			window.editorUI.postSave(editor);
		});
		

		// module quill autosave
		// and return value changeText
		changeText = window.editorUI.autoSave(editor, changeText, Delta);
		

		// get data arsip 
		// from panel sidebar
		$(document).on('click', '.arsip-mention', function(e) {
			e.preventDefault();
			window.editorUI.parsingArsipMention(editor, $(this));
		});

		window.onbeforunload = function() {
			if (changeText.length() > 0) {
				return 'There are unsaved changes. Are you sure you want to leave?';
			}
		}
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
		window.editorUI.openPanelArsip();
		window.editorUI.closePanelArsip();
		window.editorUI.panelArsip();
	}
}