<!DOCTYPE html> <!-- form.php -->
<html> <!-- This is exercise, page 32 for book "PHP tworzenien serwisow" -->
<head>
  <meta charset="utf-8" />
  <title>PHP Form</title>
  <link rel="stylesheet" type="text/css" href="css.css" />
  <script>
	function gradVerify(input) {
	  let gradV = input.value;
	  let arr=[2,3,3.5,4,4.5,5]
	  if(!arr.find(x=>x==gradV)) {
	    alert("NOT CORRECT");
	    input.value = "";
		input.style.backgroundColor = "#f99";
	  }
	  else input.style.backgroundColor = "unset";
	}
  </script>
</head>
<body>
  <form>
	User name = <input type="text" name="uName"  maxlength="8" size="3"/><br/><br/>
	<?php
	for($i=1; $i<9; $i++) {
	  echo "Grade no ".$i." = ";
	  echo "<input type='text' name='inpu".$i."' maxlength='8' size='3' onchange='gradVerify(this)'/><br/>";
	}3
	?>
	<input type="submit" name="sent" value="RUN" />
  </form>
  <?php
  //var_dump($_GET);
  //print_r($_GET);
  if(isset($_GET["sent"])) {
	$gradVar = 0; $gradNo = 0; $gradAver = 0;
	echo "<p>Results for ".$_GET["uName"]."</p>";
	for($i=1;$i<9;$i++) {
		$gradVar = $_GET['inpu'.$i]?$_GET['inpu'.$i]:"missing";
		echo "Grade no ".$i." = ".$gradVar.".<br />";
	  if($gradVar>0) {
		$gradNo++;
		$gradAver+=$gradVar;
	  }
	}
	echo "<br />Total grades: ".$gradNo.".<br />";
	echo "Total points: ".$gradAver.".<br />";
	if($gradNo > 0) {echo "Average grade: ".$gradAver/$gradNo.".<br />";}
	  else{echo "All grades missing!";}
  };
  ?>
</body>
</html>
