<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>DATABASE SAVE</title>
  <link rel="stylesheet" type="text/css" href="css.css" />
</head>
<body>
  <h2>Save Form</h2>
  <form>
    <input name="fname" />
	<input type="submit" />
  </form>
  <?php
    echo "<br />This is PHP<br />";
    if(!$base1 = mysql_connect('localhost','user1','M)M01')) {echo "Php error: ".mysql_error();}
    else {
	  echo " and SQL<br />";
	  mysql_query("SET NAMES 'utf8'");
	  $dbase = mysql_select_db("base1");
	  echo "<h3>Content of mysql_select_db</h3>";
	  var_dump($dbase);
	  //mysql_close(); //this is closing all open databases
    }
  ?>
</body>
</html>
