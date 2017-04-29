;window.ajaxCall = {
	withoutSuccess: function(ajaxUrl, ajaxType = 'GET', ajaxData) {
		try {
			$.ajax({
				url: ajaxUrl,
				type: ajaxType,
				data: ajaxData,
				dataType: 'json'
			});
		} catch (err) {
			console.log('call post ajax error ' +err);
		}
	}
}