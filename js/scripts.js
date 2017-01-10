$(function()
{
	var table = $('#dataTable').DataTable();
	
	$('#dataTable tbody').on('click', 'td.details-control', function()
	{
		var tr = $(this).closest('tr');
		var row = table.row(tr);
		
		if (row.child.isShown())
		{
			$('div.slider', row.child()).slideUp(function()
			{
				row.child.hide();
				tr.removeClass('shown');
			});
		}
		else
		{
			var rowId = $(this).attr('data-row_id');
			var $table = $('#' + rowId);
			
			row.child($table.clone(), 'no-padding').show();
			tr.addClass('shown');
			
			$('div.slider', row.child()).slideDown();
		}
	});
	
});