<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>DATABASE TEST</title>
  <link rel="stylesheet" type="txt/css" href="css.css" />
  <style></style>
</head>
<body>
  <h2>Session Form</h2>
  <form>
    <input name="fname" />
	<input type="submit" />
  </form>
  <?php
	function br() {echo "<br />";} // lazyMe 
	echo "This is PHP";
	if(!$base1 = mysql_connect('localhost','user1', 'M)M01')) {echo "PHP errors? ".mysql_error();}
	else {
	  echo " and SQL.<br />";
	  mysql_query("SET NAMES 'utf8'");
	  $fromBase1 = mysql_select_db("base1");
	  var_dump($fromBase1);
	  //mysql_close();
	} 
  ?>
  <h3>Setting up sql request</h3>
  <?php
    $sqlreq1 = "SELECT fname, lname, bday, bplace FROM b1_users";
    $sqlreq2 = "SELECT fname, lname, bday, bplace FROM b1_users WHERE role='t'";
    $answer = mysql_query($sqlreq1);
	var_dump($answer);
  ?>
  <h3>Getting lines from sql answer</h3>
  <?php

    while($record = mysql_fetch_array($answer)) {	  
	  $i = 0;
      while($i*2 < sizeof($record)) {
	    echo "<br />".($i+1).". ";
	    print_r(array_keys($record)[$i*2+1]); //array of values and keys
	    echo " = ".$record[$i]; //array of values (half of above)
	    $i++;
	  }
	  br();
	}
	//var_dump($record);
	//echo sizeof($record);
  ?>
</body>
</html>
