;window.lockedUnlockedParagraphUI = {	
	init: function() {
		$('.lock').on('click', function () {
			var lock = $(this).attr("data-lock");
			var url = $(this).data('url');
			/* function ajax required url, type method, data */
			window.ajaxCall.withoutSuccess(url, 'POST', {lock: lock});
				
			if ($(this).attr('unlocked') != 'true') {
				$(this).attr('unlocked', 'true');
				$(this).parent().addClass('bg-unlocked');
				$(this).find('i').removeClass('fa-lock').addClass('fa-unlock-alt text-success');
			} else {
				$(this).attr('unlocked', 'false');
				$(this).parent().removeClass('bg-unlocked');
				$(this).find('i').removeClass('fa-unlock-alt text-success').addClass('fa-lock');
			}
		});
	}
}