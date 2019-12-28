<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <title>Back to the PHP</title>
  <style>
    P {font-family: arial, sans-serif;}
  </style>
</head>
<body>
  <div>
    <p>IMPACT</p>
	<?php echo "<p>This is PHP</p>";
	if(isset($_GET['title'])) {	
		$title = $_GET['title'];
		echo "<p><strong>Oto miasto ".$title.":</strong></p>";
		
		if($title == "Warszawa") {echo "<p>
		Warszawa to stolica Polski i najwieksze miasto kraju. 
		Jest siedziba najwazniejszych polskich wladz panstwowych: 
		Prezydenta, Sejmu i Senatu, Rady Ministrow. 
		W stolicy zlokalizowana jest takze siedziba Narodowego Banku Polskiego, 
		unijnej agencji Frontex odpowiedzialnej za bezpieczenstwo granic 
		zewnetrznych UE oraz Biura Instytucji Demokratycznych i Praw Czlowieka 
		(ODIHR) dzialajacego pod przewodnictwem OBWE.
		</p>";}
		elseif ($title == "Lodz") {echo "<p>
		Lódz is a city in central Poland, known as a former textile-manufacturing hub. 
		Its Central Museum of Textiles displays 19th-century machinery, 
		fabrics and handicrafts linked to the trade. Once a factory, 
		the restored Manufaktura complex is now a lively culture and arts center. 
		Nearby is the grand Poznanski Palace, home to the City Museum, 
		with artwork and objects depicting the history of Lódz
		</p>";}
		elseif ($title == "Krakow") {echo "<p>Krakow, miasto stoleczne Krakow (m.st. Krakow) – stolica Polski.</p>";}
		elseif ($title == "Wroclaw") {echo "<p>Wroclaw, miasto stoleczne Wroclaw (m.st. Wroclaw) – stolica Polski.</p>";};
	}
	?>
	<p>PHP ends here.</p>	
	<a href="https://localhost/php/?title=Warszawa">Warszawa</a><br />
	<a href="https://localhost/php/?title=Lodz">Lodz</a><br />
	<a href="https://localhost/php/?title=Krakow">Krakow</a><br />
	<a href="https://localhost/php/?title=Wroclaw">Wroclaw</a><br />
	<a href="https://localhost/php/?name=AAA">none</a><br />
  </div>
</body>
</html>
