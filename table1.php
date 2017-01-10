<?php
	include_once('test_data.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Table</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"/>
	<link rel="stylesheet" href="../css/styles.css"/>
	<script src="//code.jquery.com/jquery-1.12.3.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<script src="../js/scripts.js"></script>
</head>
<body>
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<h1>Table 1</h1>
		<?php
			include_once('DataTable.php');
			
			$dataTable = new DataTable(array(
				'data' => $datastruct1,
				'col_group' => array('curvename'),
				'col_show' => array('strategy', 'curvename', 'quantity'),				
				'col_aggr_sum' => 'quantity',
				'orientation' => 'horizontal'
			));
			$dataTable->show();
		?>
    </div>
	<div class="col-md-2"></div>
</body>
</html>