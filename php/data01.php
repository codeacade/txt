<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>DATABASE TEST</title>
  <link rel="stylesheet" href="css.css" />
  <style></style>
</head>
<body>
  <h2>Session Form</h2>
  <form>
    <input name="fname" />
	<input type="submit" />
  </form>
  <?php
	echo "This is PHP";
	if(!$base1 = mysql_connect('localhost','user1', 'M)M01')) {echo "PHP errors? ".mysql_error();}
	else {
	  echo " and SQL.";
	  mysql_query("SET NAMES 'utf8'");
	  $fromBase1 = mysql_select_db("base1");
	  var_dump($fromBase1);
	  mysql_close();
	} 
  ?>
</body>
</html>