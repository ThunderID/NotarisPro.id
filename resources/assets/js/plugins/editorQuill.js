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

		let editor = new Quill(elm, options)
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