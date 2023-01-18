<?php
	require_once("DBUtils.php");

	DBUtils::initDB();
	$errors = array();

?>
<html>
	<head>
		<title>Bioskop | Rezervacija</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Spectral+SC" rel="stylesheet">
	</head>
	<body>
		<h1>Pravljenje rezervacije</h1>

		<?php

			## TO DO ##
			## Dobaviti podatke iz forme i iz query string-a.
			## Napraviti novi objekat tipa Reservation. 
			## Pozivom makeReservation upisati rezervaciju u bazu. 
		?>
			<!--
				TO DO :
				Mesto za HTML formu. 
			-->

			<div class="errors">
			<!--
				TO DO:
				Prikaz gresaka. 
			-->
			</div>
	</body>
</html>