// import jquery
import $ from 'jquery';
import 'select2';

window.Select2Input = {
	select2: function () {
		$('.select').select2();
	},
	select2tag: function () {
		$('.select-tag').select2({
			tags: true,
			allowClear: true,
			tokenSeparator: [',', ' ']
		});
	},
	select2TagCustom: function () {
		$('.select-tag-custom').select2({
			tags: true
		}).on('change', function(){
			var $selected = $(this).find('option:selected');
			var $container = $($(this).attr('data-container'));
			var $list = $('<ul class="list-unstyled">');
			
			$selected.each (function(k, v) {
				var $li = $('<li class="mb-4"></li>');
				var $linkClose = '<a href="#" class="destroy-tag-selected" data-id="'+ v.value +'"><i class="fa fa-close"></i></a>';
				var $linkDetail = '<a class="btn btn-primary btn-sm text-white float-right" data-toggle="modal" data-target="#choose-data-modal" data-id="'+ v.value +'" data-list="'+ v.dataset.list +'" style="cursor:pointer;">Lihat data</a>';

				$li.html($linkClose + $(v).text() + $linkDetail);
				$li.children('a.destroy-tag-selected')
					.off('click.select2-copy')
					.on('click.select2-copy', function(e){
						var $opt = $(this).data('select2-opt');

						$opt.attr('selected', false);
						$opt.parents('select').trigger('change');
					}).data('select2-opt', $(v));
				$li.append('<input type="hidden" name="pemilik['+ v.value +'][nama]" value="'+ v.dataset.name +'" />');
				$list.append($li);
			});
			$container.html('').append($list);
		}).trigger('change');
	},
	init: function () {
		this.select2();
		this.select2tag();
		this.select2TagCustom();
	}
}