import $ from 'jquery';
import 'jquery.caret';
import 'at.js';

window.editorUI = {
	loadingAnimation: function (flag, msg) {
		let loading = $('.loading-save');

		if (typeof msg !== 'undefined') {
			if (msg == 'loading') {
				loading.html('Menyimpan..')
					.removeClass('alert-danger alert-success')
					.addClass('alert-info')
					.prepend('<i class="fa fa-circle-o-notch fa-spin"></i> ');
			} else {
				loading.html(msg)
					.removeClass('alert-danger alert-info')
					.addClass('alert-danger')
					.prepend('<i class="fa fa-exclamation-cirlce');
			}
		} else {
			loading.html('Tersimpan')
				.removeClass('alert-danger alert-info')
				.addClass('alert-success');
		}

		loading.fadeIn();
		setTimeout( function() {
			loading.fadeOut();
		}, 2500);
	},
	autoSave: function (editor, textChange) {
		setInterval( function() {
			if (textChange.length() > 0) {
				window.editorUI.postSave(editor);
				return new Delta();
			}
		}, 5*1000);
	},
	postSave: function(editor, el, action, url) {
		let judulAkta 		= $('.input-judul-akta').val();
		let paragrafAkta 	= editor.root.innerHTML;
		let urlStore 		= editor.container.dataset.url;
		let ajaxAkta 		= window.ajax;
		let formData 		= new FormData();
		
		window.editorUI.loadingAnimation('show', 'loading');

		ajaxAkta.defineOnSuccess( function(respon) {
			window.editorUI.loadingAnimation('hide');
			window.editorUI.loadingAnimation('show');
			
			if ((typeof (el) !== 'undefined') && (el !== null)) {
				setTimeout(function(){
					// if action for button new
					if ((typeof (action) !== 'undefined') && (action !== null)) {
						// if action new file
						if (action == 'new') {
							// if data attribute url
							if ((typeof (url) != 'undefined') && (url != null)) {
								// window redirect to url
								// window.loader.show('body');
								window.location = url;
							}
						} else {
							window.close();
						}
					}
				}, 500);

			}
		});

		ajaxAkta.defineOnError( function(respon) {
			window.editorUI.loadingAnimation('hide');
			window.editorUI.loadingAnimation('show', 'Tidak dapat menyimpan akta!');
		});

		formData.append('judul', judulAkta)
		formData.append('jenis', 'test')
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
				editor.insertEmbed(range.index, 'medium-editor-mention-at', textObj);
			} else {
				editor.deleteText(range.index, range.length);
				editor.insertEmbed(range.index, 'medium-editor-mention-at', textObj);
			}
		} else {
			editor.insertEmbed(editor.getLength() - 1, 'medium-editor-mention-at', textObj);
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
		$(document).on('click', '.ql-list-arsip', function(e) {
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
		var editor = new window.Quill('.editor', options);
		var toolbar = editor.getModule('toolbar');
		// editor.enable('false');
		
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

				node.innerHTML = value.text;
				node.classList.add('text-primary');
				node.setAttribute('data-mention', value.value);
				node.setAttribute('data-value', value.text);
		        node.setAttribute('contenteditable', false);
				return node;
			}
		}

		dataMention.blotName = 'medium-editor-mention-at';
		dataMention.className = 'medium-editor-mention-at';
		dataMention.tagName = 'span';

		Quill.register({
			'formats/medium-editor-mention-at': dataMention
		});


		// function on click button new 
		// editor
		buttonNewDocument.addEventListener('click', function(e) {
			// console.log('new document');
		});

		// function on click button save
		// from editor
		buttonSaveDocument.addEventListener('click', function(e) {
			e.preventDefault();
			window.editorUI.postSave(editor);
		});

		// event save isi mention
		$('.modal .btn-mentionable').on('click', function(e) {
			e.preventDefault();

			let ajaxAkta = window.ajax;
			let formData = new FormData();
			let form = $(this).closest('form');
			let actionUrl = form.attr('action');
			let temp = {};


			form.find('input').each( function() {
				let fieldInput = $(this).attr('name');
				let valueInput = $(this).val();

				temp[fieldInput] = valueInput;
				// temp = {fieldInput: valueInput};
			});

			console.log(JSON.stringify(temp));

			window.editorUI.loadingAnimation('show', 'loading');

			ajaxAkta.defineOnSuccess( function(respon) {
				window.editorUI.loadingAnimation('hide');
				window.editorUI.loadingAnimation('show');
			});

			ajaxAkta.defineOnError( function(respon) {
				window.editorUI.loadingAnimation('hide');
				window.editorUI.loadingAnimation('show', 'Tidak dapat menyimpan isi dari dokumen!');
			});

			formData.append('mentionable', JSON.stringify(temp));
			// console.log(formData);
			ajaxAkta.post(actionUrl, formData);

		});

		$('.modal .btn-save-dokumen').on('click', function (e) {
			e.preventDefault();

			let actionButton = $(this).attr('data-action-button');
			let actionUrl = $(this).attr('data-url');

			if ((typeof (actionUrl) != 'undefined') && (actionUrl != null)) {
				window.editorUI.postSave(editor, 'modal', actionButton, actionUrl);
			} else {
				window.editorUI.postSave(editor, 'modal', actionButton);
			}
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

		let paragraf = typeof (editor.container.dataset.paragraf) !== 'undefined' ? editor.container.dataset.paragraf : null;

		if ((paragraf !== '') && (paragraf !== null)) {
			editor.root.innerHTML = null;
			$.map(JSON.parse(editor.container.dataset.paragraf), function(k, v) {
				editor.root.innerHTML += k.konten;
				// window.editorUI.init();
			});	
		}
	},
	init: function () {
		window.editorUI.quill();
		window.editorUI.openPanelArsip();
		window.editorUI.closePanelArsip();
		window.editorUI.panelArsip();
	}
}