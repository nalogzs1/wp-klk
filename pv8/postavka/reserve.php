<?php
	require_once("config.php");
	require_once("database_utils.php");

	initDB();

	$message = "";
	$flight = null;
	$count = 0;

	if (isset($_GET["id"]) && isset($_GET["count"])) {
		$flight = getFlight($_GET["id"]);
		if ($flight) {
			$count = min(max($_GET["count"], 0), MAX_TICKETS);
			if (isset($_POST["rezervacija"])) {
				
				// TODO 3: Sačuvati sve podatke iz forme u kukijima

				$success_count = 0;
				for ($i = 0; $i < $count; $i++) {
					$name = $_POST["name"][$i];
					$passport = $_POST["passport"][$i];
					if (makeReservation($_GET["id"], $name, $passport)) {
						$success_count++;
					}
				}
				if ($success_count == $count) {
					$message = "Rezervacija je uspešno napravljena.";
					$count = 0;
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Avionske karte</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1>Rezervacija karte</h1>
	<h2>
	<?php
		if ($flight == null) {
			echo "Nepostojeći let.";
		} else {
			echo "Let {$flight[COL_FLIGHT_FROM]}-{$flight[COL_FLIGHT_TO]}";
		}
	?>
	</h2>
	<div><a href="index.php">Vrati se na pretragu</a></div>
	<?php 
		if ($count) {
	?>
	<!-- TODO 4: Modifikovati formu ispod tako da prikazuje podatke iz kukija (ukoliko ti podaci postoje). -->
	<form method="POST" action="<?php echo "?id=".$_GET["id"]."&count=".$_GET["count"];?>">
		<?php
			for ($i = 0; $i < $count; $i++) {
		?>
				<fieldset>
					<legend>Putnik <?php echo $i + 1; ?></legend>
					Ime i prezime: <input type="text" name="name<?php echo "[$i]"; ?>"/>
					Broj pasoša: <input type="text" name="passport<?php echo "[$i]"; ?>"/>
				</fieldset>
		<?php 
			}
		?>
		<input type="submit" value="Rezerviši" name="rezervacija"/>
	</form>
	<?php 
		}
	?>
</body>
</html>
