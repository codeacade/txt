<!DOCTYPE html><!-- table.php -->
<html>
<head>
  <meta charset="utf-8" />
  <title>Grade Table</title>
  <link rel="stylesheet" type="text/css" href="css.css" />
  <style>
	.tablee {
		display: table;
		background-color: #aaa;
		margin: 10px; 
		padding: 10px;
		color: #fff;
	}
	.roww {display: table-row;}
	.celll {
		display: table-cell;
		width: 19%;
	}
	h2 {color: #888; margin-left: 10px;}
  </style>
  <script>
    function chColor(d){d.querySelector(".cell:hover").style.backgroundColor = "blue"}
  </script>
</head>
<body>
    <h2>THIS IS GRADING TABLE:</h2>	
	<?php // function to translate pints into grades
	function pointsToGrades($points) {
	  if($points<20) return 2;
	  if($points<25) return 3;
	  if($points<30) return 3.5;
	  if($points<35) return 4;
	  if($points<38) return 4.5;
	  return 5;
	}
	
	
	// read data from grades.txt file to $table Array
	// $tableRows equals number of size of $table Array (n+1)
	// $table = file("grades.txt");
	$table = file("points.txt");
	$tableRows = count($table);
	?>
  <div class="tablee">
	<div class="roww">
	  <div class="celll">First Name:</div>
	  <div class="celll">Last Name:</div>
	  <div class="celll">Grade:</div>
	</div>
  <?php // filling table rows with data from grades.txt file
    // $tableRows is an Array of all rows from file
	// $row is a counter from 0 to last element of $tableRows
	// $cells is an Array of cutted string from $tableRows[]
	$row = 0;
	while($row < $tableRows) {
	$cells = explode(";",$table[$row]);
	echo '
	<div class="roww">
	  <div class="celll">'.$cells[0].'</div>
	  <div class="celll">'.$cells[1].'</div>
	  <div class="celll">'.pointsToGrades($cells[2]).'</div>
	</div>	
	';
	$row++;}
  ?>
  </div>
  <p style="margin-bottom: 5px;"> PIXELS </p>
  <div class="container" onclick="chColor(this)">
	<div class="row">
	  <div class="cell"></div>
	  <div class="cell"></div>
	  <div class="cell"></div>
	  <div class="cell"></div>
	</div>
  </div>
</body>
</html>
