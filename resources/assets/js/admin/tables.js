const adminTable = ($ => {
	let table = null;
	let ajax_url = null;
	let minDate = null;
	let maxDate = null;
	
	function init() {
		addDateSearchExtentionToDataTables();
		table = $('#data-table-wrapper').DataTable({
			rowId: 'row-id',
			layout: {
				topStart: {
					buttons: ['colvis',
						{
						    extend: 'csv',
							exportOptions: {
						        columns: ['.dragonfw-col-data:visible']
						    }
						},
						{
		                    extend: 'pdfHtml5',
							exportOptions: {
		                        columns: ['.dragonfw-col-data:visible']
		                    }
		                },
						{
		                    extend: 'searchPanes',
		                    config: {
		                        cascadePanes: true,
								i18n: {
						            loadMessage: 'Only showing columns with sufficient grouping. (Multiple items with the same text)'
						        },
								columns: ['.dragonfw-col-data:visible']
		                    }
		                }
					]
				}
			},
			stateSave: true,
			initComplete: function () {
		        this.api()
		            .columns()
		            .every(function () {
		                var column = this;
		                var title = column.footer().textContent;
		                $('<input type="text" style="width:100%" placeholder="Search ' + title + '" />')
		                    .appendTo($(column.footer()).empty())
		                    .on('keyup change clear', function () {
		                        if (column.search() !== this.value) {
		                            column.search(this.value).draw();
		                        }
		                    });
		            });
		    },
		});
		
		ajax_url = $('#data-table-wrapper tbody').attr('data-ajax');
		addActionClickHandler();
		addSelectedRowHandler();
		addDeleteRowHandler();
		addRowEditHandler();
		addDateSearchListener();
	}
	
	function addDateSearchExtentionToDataTables() {
		DataTable.ext.search.push(function (settings, data, dataIndex) {
		    let min = minDate.val();
		    let max = maxDate.val();
			let dateColumnIndex = $('#dragonfw-date-search').attr('data-column-index');
			
		    let date = new Date(data[dateColumnIndex]);
		 
		    if (
		        (min === null && max === null) ||
		        (min === null && date <= max) ||
		        (min <= date && max === null) ||
		        (min <= date && date <= max)
		    ) {
		        return true;
		    }
		    return false;
		});
		
		minDate = new DateTime('#date-min', {
		    format: 'yyyy-LL-dd',
			buttons: {
				clear: true,
			}
		});
		maxDate = new DateTime('#date-max', {
		    format: 'yyyy-LL-dd',
			buttons: {
				clear: true,
			}
		});
	}
	
	function addDateSearchListener() {
		document.querySelectorAll('#date-min, #date-max').forEach((el) => {
		    el.addEventListener('change', () => table.draw());
		});
	}
	
	function addSelectedRowHandler() {
		$('#data-table-wrapper').on('click', 'tbody tr', function (e) {
			e.currentTarget.classList.toggle('selected');
		});
	}
	
	function addActionClickHandler() {
		$('#data-table-wrapper').on('dblclick', '.action_button', function (e) {
			e.stopPropagation();
		});
		
		$('#data-table-wrapper').on('click', '.action_button', function (e) {
			e.stopPropagation();
			window.location = $(this).attr('data-link');
		});
	}
	
	function addDeleteRowHandler() {
		$('#dragon-table-delete-button').on('click', function () {
			$('#data-table-wrapper .selected').each(function () {
				let rowId = $(this).attr('data-row-id');
				$.post(ajax_url, {
					'action': $('#data-table-wrapper tbody').attr('data-delete-action'),
					'id': rowId,
					'route': $('#data-table-wrapper tbody').attr('data-route'),
					'delete_action': $('#dragon-table-delete-button').attr('data-action')
				});
				
				table.row('.selected').remove().draw(false);
			});
		});
	}
	
	function addRowEditHandler() {
		$('#data-table-wrapper').on('dblclick', 'tbody tr', function (e) {
			let rowId = $(this).attr('data-row-id');
			let updatePage = $('#data-table-wrapper tbody').attr('data-details-page');

			if (updatePage.length > 0 && (rowId > 0 || typeof rowId === 'string')) {
				window.location = updatePage + "&id=" + rowId;
			}
		});
	}
	
	return { init };
})(jQuery);

jQuery(document).ready(adminTable.init);
