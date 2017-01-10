<?php

class DataTable
{
	private $data;
	private $data_show = array();
	private $col_aggr_sum = false;
	private $col_group;
	private $col_show;
	private $orientation;
	
	public function __construct($param)
	{
		foreach($param as $key => $val)
			$this->$key = $val;
		
		$this->createStructData();
		$this->addDetailsInRows();
	}
	
	// create data struct from data
	private function createStructData()
	{
		foreach ($this->data as $item)
		{
			$row = array();
			
			foreach ($item as $key => $val)
				if( in_array($key, $this->col_show) && $key != $this->col_aggr_sum)
					$row[$key] = $val;
			
			if( count($row) )
			{
				if($this->col_aggr_sum)
					$row[$this->col_aggr_sum] = 0;
				
				$row['details'] = array();
				$this->data_show[] = $row;
			}
		}
		
		$this->data_show = array_unique($this->data_show, SORT_REGULAR);
	}
	
	// create details of rows
	private function addDetailsInRows()
	{
		foreach ($this->data_show as &$row)
			foreach ($this->data as $row_original)
			{
				$is_group = true;
				
				foreach ($this->col_group as $key)
					if($row[$key] != $row_original[$key])
						$is_group = false;
				
				if($is_group)
				{
					// total amount
					if($this->col_aggr_sum)
						$row[$this->col_aggr_sum] += $row_original[$this->col_aggr_sum];
					
					// add details
					$row_tmp = array();
					
					foreach ($this->data[0] as $col => $val)
						if(!in_array($col, $this->col_show) || $col == $this->col_aggr_sum)
							$row_tmp[$col] = $row_original[$col];
					
					$row['details'][] = $row_tmp;
				}
			}
	}
	
	// show column from table
	private function showColumn()
	{
		echo '<thead>
			<th></th>';
			
			foreach ($this->col_show as $col)
				echo '<th>' . $col . '</th>';
		
		echo '</thead>';
	}
	
	// show rows from table
	private function showRows()
	{
		echo '<tbody>';
		
			foreach ($this->data_show as $key => $row)
			{
				echo '<tr>
					<td class="details-control" data-row_id="row_' . $key . '"></td>';
					
					foreach ($row as $col => $val)
						if( in_array($col, $this->col_show) )
							echo '<td>' . $val . '</td>';
				
				echo '</tr>';
			}
		
		echo '</tbody>';
	}
	
	// show table details horizontal
	private function showDetailsHorizontal()
	{
		$style = $this->col_aggr_sum ? 'table-details-left' : 'table-details-right';
		
		foreach ($this->data_show as $key => $row)
		{
			echo '<div id="row_' . $key . '" class="slider ' . $style . '">
				<table class="table table-striped">
					<thead>
						<tr>';

							foreach ($row['details'][0] as $col => $val)
								echo '<th>' . $col . '</th>';
			
						echo '</tr>
					</thead>
					<tbody>';
						
						foreach ($row['details'] as $item)
						{
							echo '<tr>';

							foreach ($item as $col => $val)
								echo '<td class="' . $col . '">' . $val . '</td>';

							echo '</tr>';
						}

					echo '<tbody>
				</table>
			</div>';
		}
	}
	
	// show table details vertical
	private function showDetailsVertical()
	{
		foreach ($this->data_show as $key => $item)
		{
			echo '<div id="row_' . $key . '" class="slider table-details-right">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Index:</th>';
					
							foreach ($item['details'] as $key => $val)
								echo '<th>' . $key . '</th>';
					
						echo '</tr>
					</thead>
					<tbody>';
					
						foreach ($item['details'][0] as $key => $val)
						{
							echo '<tr>';
							echo '<th>' . $key . ':</th>';

							foreach ($item['details'] as $row)
								echo '<td class="' . $key . '">' . $row[$key] . '</td>';

							echo '</tr>';
						}
					
					echo '</tbody>
				</table>
			</div>';
		}
	}
	
	// show table
	public function show()
	{
		echo '<table id="dataTable" class="table table-striped table-bordered">';
		
		$this->showColumn();
		
		$this->showRows();
		
		echo '</table>';
		
		if($this->orientation == 'horizontal')
			$this->showDetailsHorizontal();
		else if($this->orientation == 'vertical')
			$this->showDetailsVertical();
	}
	
}

?>
