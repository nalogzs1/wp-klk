<?php
	require_once("DBUtils.php");
    require_once("classes/Reservation.php");
    require_once("classes/Movie.php");

	DBUtils::initDB();

	$errors = array();

    $movie = null;
	$reservation_seat = "";
	if (isset($_GET["movie"])) {
		$movie_id = $_GET["movie"];
		$movie = DBUtils::getMovieById($movie_id);
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

	if (isset($_POST["rezervisi"]) && count($errors) == 0) {
		$reservation_name =  htmlspecialchars($_POST['name']);
		$reservation_phone = htmlspecialchars($_POST['phone']); 
		$reservation_email = htmlspecialchars($_POST['email']);
		$reservation = new Reservation($movie, $reservation_seat, $reservation_name, $reservation_phone, $reservation_email);
		$success = DBUtils::makeReservation($reservation);
		if ($success) {
			// Preusmeravanje korisnika na index.php stranicu.
			header("Location: index.php");
		} else {
			$errors[] = "Rezervacija nije uspešno napravljena.";
		}
	}		
?>
<html>
	<head>
		<title>Bioskop | Rezervacija</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link href="https://fonts.googleapis.com/css?family=Spectral+SC" rel="stylesheet">
	</head>
	<body>
		<h1>Pravljenje rezervacije</h1>
		<a href="index.php"><button>Povratak na početnu stranu</button></a>
		
		<form method="POST" action="?movie=<?php echo $movie->getId()?>&seat=<?php echo $reservation_seat;?>">
			<h2>
				Rezervacija za film <?php echo $movie->getTitle();?>, red <?php echo $row;?>, kolona <?php echo $col;?>
				?>
			</h2>
			<div>
				<label for="name">Ime i prezime</label><br>
				<input type="text" name="name"/>
			</div>
			<div>
				<label for="phone">Broj telefona</label><br>
				<input type="text" name="phone"/>
			</div>
			<div>
				<label for="email">Email</label><br>
				<input type="text" name="email"/>
			</div>
			<input type="submit" name="rezervisi" value="Rezerviši"/>
		</form>

		<div class="errors">
		<?php
			foreach ($errors as $error) {
				echo "<div>$error</div>";
			}
		?>
		</div>
	</body>
</html>