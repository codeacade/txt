<?php
session_start();
if(isset($_GET["fname"])) {
	echo "This <b>fname</b> is: ".$_GET["fname"]."<br />";
	if(!isset($_SESSION['ttt'])) {
	  $_SESSION["ttt"] = array();
	}
	$_SESSION["ttt"][] = $_GET["fname"];
}
var_dump($_SESSION["ttt"]);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>SESSION_START TEST</title>
  <link rel="stylesheet" href="css.css" />
  <style></style>
</head>
<body>
  <h2>Session Form</h2>
  <form action="session3.php">
    <input name="fname" />
	<input type="submit" />
  </form>
</body>
</html>