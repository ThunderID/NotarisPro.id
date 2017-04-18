;window.editorUI = {
	renderListMention: function (data, callBack) {
		list = '';

		for (var i in data) {
			link = "<a href='#' class='list-group-item list-group-item-action p-1 link-mention'>" +data[i]+ "</a>";
			list += link;
		}

		return list;
	},
	searchMention: function (param) {
		var search = param.toLowerCase().substr(1);
		var result = {};

		try {
			for (var i in dataListWidgets) {
				if (i.toLowerCase().indexOf(search) > -1) {
					result[i] = dataListWidgets[i];
				}
			}
		} catch (err) {
			result['no_result'] = 'No Result';
		}

		return result;
	},
	init: function () {
		var editor = new window.Editor(".editor", {
	    	// button on toolbar medium-editor
			toolbar: {
				buttons: ["bold", "italic", "underline", "justifyLeft", "justifyCenter", "justifyRight", "orderedlist", "unorderedlist"]
			},
			placeholder: {
				text: "Tulis disini",
				hideOnClick: true,
			},
			buttonLabels: "fontawesome",
			paste: {
				cleanPastedHTML: true,
				forcePlainText: false,
			},
			spellcheck: false,
			disableExtraSpaces: true,
			targetBlank: true,
			extensions: {
				mention: new window.Mention({
					extraPanelClassName: 'list-group',
					tagName: 'b',
					renderPanelContent: function (panelEl, currentMentionText, selectMentionCallback) {
						this.mention = window.editorUI.searchMention(currentMentionText);
						if ([this.mention].length != 0) {
							listMention = window.editorUI.renderListMention(this.mention, selectMentionCallback);
							$(panelEl).html(listMention);
						}

						$('.link-mention').on('click', function(el) {
							selectMentionCallback($(this).html());
						});
					},
					activeTriggerList: ["@"],
				})
			}
		});
	}
}