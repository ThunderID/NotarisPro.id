;window.listSearchUI = {
	searchOrganisasi : function () {
		options = {
		    valueNames: [ 'name' ]
		};
		var search = new List('list-organisasi', options);
	},
	searchTemplate : function () {
		options = {
		    valueNames: [ 'name' ]
		};
		var search = new List('list-template', options);		
	},
	init: function () {
		window.listSearchUI.searchOrganisasi();
		// window.listSearchUI.searchTemplate();
	}
}