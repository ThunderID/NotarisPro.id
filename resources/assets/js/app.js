// PLUGINS
// medium-editor
window.Editor = require ('./plugins/medium-editor/medium-editor.js');
// tcmention
window.Mention = require("medium-editor-tc-mention").TCMention;

// plugin search list
window.list = require('./plugins/list-js/list.js');


// app UI
require ('./appUI');
;window.listSearchUI.init();


//requirements

// clickable table row
require('./plugins/clickableTableRow');

// margin editor drawer
require('./plugins/marginDrawer');

// editor auto page break
require('./plugins/editorAutoPage');

// plugin equal height
require('./plugins/equalHeight.js');

//toggle menu
require('./plugins/toggleMenu.js');

//searchList
require('./plugins/searchList.js');

//stripeGenerator
// require('./plugins/stripeGenerator.js');