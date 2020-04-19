<!DOCTYPE html>
<html>
<head>
  <meta charser="utf-8" />
  <title>BAZA ACCESS</title>
  <style>
    body {
      font-family: Arial, Helvetica, Ubuntu, sans-serif;
    }
  </style>
</head>
<body>
  <h2>HEADER</h2>
  <?php 
  //$baza = mysqli_connect('localhost','buser01','M)M01');
  $baza = new mysqli('localhost','abuser01','M)M01');
  //if ($baza === false) die("Dbase connection error: ".$baza->error)
  echo "<p>connect_errno: </p>";
  var_dump($baza->connect_errno);
  echo "<p>connect_error: </p>";
  var_dump($baza->connect_error);
  ?>
</body>
</html>
