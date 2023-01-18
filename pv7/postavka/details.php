<?php
	require_once("DBUtils.php");
	DBUtils::initDB();

	$errors = array();
?>
<html>
	<head>
		<title>Bioskop | Detalji</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Spectral+SC" rel="stylesheet">
	</head>
	<body>
		<h1>Detalji rezervacije</h1>
		<a href="./"><button>Povratak na početnu stranu</button></a>
		<?php
			$reservation_movie_id = "";
			$reservation_seat = "";
			if (isset($_GET["movie"])) {
				$reservation_movie_id = $_GET["movie"];
			}
			if (isset($_GET["seat"])) {
				$reservation_seat = $_GET["seat"];
			}

			$seat_exploded = explode("-", $reservation_seat);
			$row = "-";
			$col = "-";
			if (count($seat_exploded) == 2) {
				$row = $seat_exploded[0];
				$col = $seat_exploded[1];
			} else {
				$errors[] = "Format sedišta nije odgovarajući.";
			}

			$reservation = DBUtils::getReservation($reservation_movie_id, $reservation_seat);
			if ($reservation) {
				echo $reservation->getHtml();
			} else {
				$errors[] = "Tražena rezervacija ne postoji.";
			}
		?>
		<div class="errors">
			<?php
				foreach ($errors as $error) {
					echo "<div>$error</div>";
				}
			?>
		</div>
	</body>
</html>