// PLUGINS
// medium-editor
window.Editor = require ('./plugins/medium-editor/medium-editor.js');
// tcmention
window.Mention = require("medium-editor-tc-mention").TCMention;
// clickable table row
require('./plugins/clickableTableRow');
// plugin search list
window.list = require('./plugins/list-js/list.js');


// app UI
require ('./appUI');
;window.listSearchUI.init();