// PLUGINS
// medium-editor
window.Editor = require ('./plugins/medium-editor/medium-editor.js');
// tcmention
window.Mention = require("medium-editor-tc-mention").TCMention;
// clickable table row
require('./plugins/clickableTableRow');


// app UI
require ('./appUI');