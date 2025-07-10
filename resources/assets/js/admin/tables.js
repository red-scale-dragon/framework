const adminTable = ($ => {
	let table = null;
	let ajax_url = null;
	
	function init() {
		table = $('#data-table-wrapper').DataTable({
		  rowId: 'row-id',
		  layout: {
	          topStart: {
	              buttons: ['csv', 'colvis']
	          }
	      }
		});

		ajax_url = $('#data-table-wrapper tbody').attr('data-ajax');
		addSelectedRowHandler();
		addDeleteRowHandler();
		addRowEditHandler();
	}
	
	function addSelectedRowHandler() {
		$('#data-table-wrapper').on('click', 'tbody tr', function (e) {
		    e.currentTarget.classList.toggle('selected');
		});
	}
	
	function addDeleteRowHandler() {
		$('#dragon-table-delete-button').on('click', function () {
			$('#data-table-wrapper .selected').each(function () {
				let rowId = $(this).attr('data-row-id');
				$.post(ajax_url, {
					'action': $('#data-table-wrapper tbody').attr('data-delete-action'),
					'id': rowId,
					'route': $('#data-table-wrapper tbody').attr('data-route')
				});
				
				table.row('.selected').remove().draw(false);
			});
		});
	}
	
	function addRowEditHandler() {
		$('#data-table-wrapper').on('dblclick', 'tbody tr', function (e) {
			let rowId = $(this).attr('data-row-id');
			let updatePage = $('#data-table-wrapper tbody').attr('data-details-page');
			
			if (updatePage.length > 0 && rowId > 0) {
				window.location = updatePage + "&id=" + rowId;
			}
		});
	}
	
	return { init };
})(jQuery);

jQuery(document).ready(adminTable.init);
