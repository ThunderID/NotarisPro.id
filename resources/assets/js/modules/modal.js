window.ModuleModal = {
	modalDataDokumen: function (url) {
		$('#choose-data-modal').on('show.bs.modal', function(e) {
			var idTarget = $(e.relatedTarget).attr('data-id');
			var urlArsip = url + '/' + idTarget + '?jenis=ktp';

			$(this).find('form')
				.attr('data-action', url + '/' + idTarget + '/dokumen/update');

			window.ArsipList.getDataDokumen(urlArsip);
		});
	},
	modalHide: function (container) {
		$(container).modal('hide');

		$('.modal').on('hide.bs.modal', function(e) {
			$('input').val('');
			$('textarea').html('');
			$('select').children().removeAttr('selected');
		});
	}
}