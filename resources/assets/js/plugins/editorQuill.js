let Quill = require ('../../../../node_modules/quill/dist/quill.js');

var container = document.getElementsByClassName('editor');

var container = '.editor'
window.editorUI = {
	selector: {
		editor: container
	},
	init: function () {
		let elm = window.editorUI.selector.editor;
		let options = {
			debug: 'info',
			modules: {
				toolbar: '#toolbar-editor'
			},
			theme: 'snow'
		}

		var editor = new Quill(elm, options)


		$('.form-editor-akta-save').on('click', function(e){
			e.preventDefault();
			window.editorUI.save(editor);
		});
	},
	save: function (editor) {
		let judulAkta 		= $('.input-judul-akta').val();
		let jenisAkta 		= $('.input-jenis-akta').val();
		let paragrafAkta 	= editor.root.innerHTML;
		let urlStore 		= editor.container.dataset.url;
		let ajaxAkta 		= window.ajax;
		let formData 		= new FormData();
		
		// window.editorUI.loadingAnimation('show', 'loading');

		ajaxAkta.defineOnSuccess( function(respon) {
			console.log(respon);
			// window.editorUI.loadingAnimation('hide');
			// window.editorUI.loadingAnimation('show');
			
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
		});

		ajaxAkta.defineOnError( function(respon) {
			console.log(respon);
			// window.editorUI.loadingAnimation('hide');
			// window.editorUI.loadingAnimation('show', 'Tidak dapat menyimpan akta!');
		});

		formData.append('judul', judulAkta)
		formData.append('jenis', jenisAkta)
		formData.append('paragraf', paragrafAkta);

		ajaxAkta.post(urlStore, formData);
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