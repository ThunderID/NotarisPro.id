;window.lockedUnlockedParagraphUI = {	
	init: function() {
		$('.lock').on('click', function () {
			var lock = $(this).attr("data-lock");
			var url = $(this).data('url');
			/* function ajax required url, type method, data */
			window.ajaxCall.withoutSuccess(url, 'POST', {lock: lock});
				
			if ($(this).attr('unlocked') != 'true') {
				$(this).attr('unlocked', 'true');
				$(this).find('i').removeClass('fa-lock').addClass('fa-unlock');
				$(this).parent().parent().addClass('unlocked');
			} else {
				$(this).attr('unlocked', 'false');
				$(this).find('i').removeClass('fa-unlock').addClass('fa-lock');
				$(this).parent().parent().removeClass('unlocked');
			}
		});
	}
}