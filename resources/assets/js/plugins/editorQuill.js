import $ from 'jquery';
let Quill = require ('../../../../node_modules/quill/dist/quill.js');

var container = document.getElementsByClassName('editor');

var container = '.editor'
window.editorUI = {
	selector: {
		editor: container
	},
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
	editorSingle: function (selector) {
		let options = {
			debug: 'info',
			modules: {
				toolbar: '#toolbar-editor'
			},
			theme: 'snow'
		}

		var editor = new Quill(selector, options)

		$('.form-editor-akta-save').on('click', function(e){
			e.preventDefault();
			window.editorUI.save(editor);
		});
	},
	editorMultiple: function () {


	},
	init: function () {
		let elm = window.editorUI.selector.editor;
		this.editorSingle(elm);

		
	},
	save: function (editor) {
		let judulAkta 		= $('.input-judul-akta').val();
		let jenisAkta 		= $('.input-jenis-akta').val();
		let paragrafAkta 	= editor.root.innerHTML;
		let urlStore 		= editor.container.dataset.url;
		let ajaxAkta 		= window.ajax;
		let formData 		= new FormData();
		
		window.editorUI.loadingAnimation('show', 'loading');

		ajaxAkta.defineOnSuccess( function(respon) {
			window.editorUI.loadingAnimation('hide');
			window.editorUI.loadingAnimation('show');
			
			// if ((typeof (el) !== 'undefined') && (el !== null)) {
				// setTimeout(function(){
					// if action for button new
					// if ((typeof (action) !== 'undefined') && (action !== null)) {
						// if action new file
						// if (action == 'new') {
							// if data attribute url
							// if ((typeof (url) != 'undefined') && (url != null)) {
								// window redirect to url
								// window.loader.show('body');
								// window.location = url;
							// }
						// } else {
							window.close();
						// }
					// }
				// }, 500);

			// }
			console.log(respon);
		});

		ajaxAkta.defineOnError( function(respon) {
			window.editorUI.loadingAnimation('hide');
			window.editorUI.loadingAnimation('show', 'Tidak dapat menyimpan akta!');
			console.log(respon);
		});

		formData.append('judul', judulAkta)
		formData.append('jenis', jenisAkta)
		formData.append('paragraf', paragrafAkta);

		ajaxAkta.post(urlStore, formData);
	},
	helperAction: function (editor) {

	}
}

// let elementEditor = document.querySelectorAll(container);

// elementEditor.forEach(function (el) {
// 	let editor = new Quill(el, {
// 		placeholder: 'Compose an epic...',
// 		theme: 'snow',
// 		modules: {
// 			toolbar: '#toolbarPane'
// 		}
// 	});
// });