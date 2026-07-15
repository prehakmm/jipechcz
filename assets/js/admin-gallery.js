/* Galerie metabox – výběr více obrázků + řazení */
jQuery(function ($) {
	var frame;
	var list = $('#jipech-gallery-list');
	var input = $('#jipech-gallery-ids');

	function sync() {
		var ids = list.find('li').map(function () { return $(this).data('id'); }).get();
		input.val(ids.join(','));
	}

	if (list.sortable) {
		list.sortable({ items: '> li', update: sync });
	}

	$('#jipech-gallery-add').on('click', function (e) {
		e.preventDefault();
		if (frame) { frame.open(); return; }
		frame = wp.media({
			title: 'Vyberte fotografie realizace',
			multiple: true,
			library: { type: 'image' },
			button: { text: 'Přidat do galerie' }
		});
		frame.on('select', function () {
			frame.state().get('selection').each(function (att) {
				var a = att.toJSON();
				if (list.find('li[data-id="' + a.id + '"]').length) { return; }
				var url = (a.sizes && a.sizes.thumbnail) ? a.sizes.thumbnail.url : a.url;
				list.append('<li data-id="' + a.id + '"><img src="' + url + '" width="90" height="90" style="object-fit:cover;" /><button type="button" class="jipech-remove" aria-label="Odebrat">&times;</button></li>');
			});
			sync();
		});
		frame.open();
	});

	list.on('click', '.jipech-remove', function (e) {
		e.preventDefault();
		$(this).closest('li').remove();
		sync();
	});

	$('#jipech-gallery-clear').on('click', function (e) {
		e.preventDefault();
		if (window.confirm('Opravdu vymazat všechny fotografie z galerie?')) {
			list.empty();
			sync();
		}
	});
});
