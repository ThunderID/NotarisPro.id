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
		var buttonOpenArsip = document.querySelector('.ql-open-arsip');
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

		// function on click button new document
		buttonNewDocument.addEventListener('click', function() {
			console.log('new document');
		});

		// function on click button save
		function post () {
			let method = "post";
			let form = document.createElement("form");
			let hiddenField = document.createElement("input");

			form.setAttribute("method", method);
			form.setAttribute("action", "/test");

			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "contents");

			hiddenField.setAttribute("value", JSON.stringify(editor.root.innerHTML));
			
			form.appendChild(hiddenField);
			document.body.appendChild(form);
			form.submit();

			// $(form).serialize();

		}

		buttonSaveDocument.addEventListener('click', function() {
			post();
		});

		// function on click button open arsip
		buttonOpenArsip.addEventListener('click', function() {
			var flag = buttonOpenArsip.getAttribute('data-flag');
			if (flag == 'close') {
				$('#DataList').css('display', 'block');
				buttonOpenArsip.setAttribute('data-flag', 'open');
				buttonOpenArsip.classList.add('ql-active');
			} else {
				$('#DataList').css('display', 'none');
				buttonOpenArsip.setAttribute('data-flag', 'close');
				buttonOpenArsip.classList.remove('ql-active');
			}
		});

		// Data Mention
		editor.on('text-change', function(delta) {
			changeText = changeText.compose(delta);
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

		$('.data-mention').on('click', function(e) {
			e.preventDefault();

			var textValue = $(this).attr('data-value');
			var textObj = {text: textValue, value: textValue};

			// set selection
			var range = editor.getSelection();
			var text = editor.getText(range.index, range.length);
			var newIndex = parseInt(range.index + textValue.length);

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
		});


		// save doucment using interval autosave
		setInterval( function() {
			if (changeText.length() > 0) {
				console.log('saving changes..');
				$.ajax({
					method: 'POST',
					url: '/test',
					data: { content: editor.root.innerHTML },
				})
				changeText = new Delta();
			}
		}, 5*1000);

		window.onbeforunload = function() {
			if (changeText.length() > 0) {
				return 'There are unsaved changes. Are you sure you want to leave?';
			}
		}

		// save document using button submit
		$('.save-document').on('click', function(){
			let method = "post";
			let form = document.createElement("form");
			let hiddenField = document.createElement("input");

			form.setAttribute("method", method);
			form.setAttribute("action", "/test");

			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "contents");

			if (changeText.length() > 0) {
				let getDocument = JSON.stringify(editor.getContents());
				let getPartialDocument = JSON.stringify(changeText);

				// console.log({
				// 	innerHTMLJSONparse: JSON.stringify(editor.root.innerHTML),
				// });
				// hiddenField.setAttribute("value", getEntryDocument);
			}


			
			form.appendChild(hiddenField);
			document.body.appendChild(form);
			// form.submit();
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