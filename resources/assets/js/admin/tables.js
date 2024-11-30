const adminTable = ($ => {
	function init() {
		let table = new DataTable('#data-table-wrapper');
	}
	
	return { init };
})(jQuery);

jQuery(document).ready(adminTable.init);
