// PLUGINS
// medium-editor
window.Editor = require ('./plugins/medium-editor/medium-editor.js');
// tcmention
window.Mention = require("medium-editor-tc-mention").TCMention;

// plugin search list
window.list = require('./plugins/list-js/list.js');

// app animation loading like youtube
window.appLoading = require('./plugins/app-loading.js');

// plugin select2
require('./plugins/select2.js');

// plugin inputmask RobinHerbots/inputmask documention: https://github.com/RobinHerbots/Inputmask
var Inputmask = require ('./plugins/jquery.inputmask.bundle.js');


// app UI
require ('./appUI');
;window.listSearchUI.init();


//requirements

// clickable table row
require('./plugins/clickableTableRow');

// margin editor drawer
// require('./plugins/marginDrawer');

// editor auto page break
// require('./plugins/editorAutoPage');

// plugin equal height
require('./plugins/equalHeight.js');

//toggle menu
require('./plugins/toggleMenu.js');

//searchList
require('./plugins/searchList.js');

//stripeGenerator
require('./plugins/stripeGenerator.js');

// shortcuts
require('./plugins/hotkey/hotkey.js');

// footer
require('./plugins/footerGenerator.js');

// quill (text editor)
window.Quill = require('./plugins/quill/quill.js');

// require('./plugins/atjs/jquery.caret.js');
// window.atwho = require('./plugins/atjs/jquery.atwho.js');

// laoder ui
require('./plugins/loader');

// ajax
require('./plugins/ajax');

// stringManipulator
require('./plugins/stringManipulator');

// print any element
require('./plugins/printElement');