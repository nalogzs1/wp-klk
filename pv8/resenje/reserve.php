<?php
	require_once("config.php");
	require_once("database_utils.php");

	initDB();

	$message = "";
	$flight = null;
	$count = 0;

	$form_data = $_COOKIE;

	if (isset($_GET["id"]) && isset($_GET["count"])) {
		$flight = getFlight($_GET["id"]);
		if ($flight) {
			$count = min(max($_GET["count"], 0), MAX_TICKETS);
			if (isset($_POST["rezervacija"])) {
				$success_count = 0;
				for ($i = 0; $i < $count; $i++) {
					$name = htmlspecialchars($_POST["name"][$i]);
					$passport = htmlspecialchars($_POST["passport"][$i]);
					$form_data["name".$i] = $name;
					$form_data["passport".$i] = $passport;
					if (makeReservation($_GET["id"], $name, $passport)) {
						$success_count++;
					}
				}
				if ($success_count == $count) {
					$message = "Rezervacija je uspešno napravljena.";
				} else {
					$message = "Rezervacija za neke putnike nije uspela.";
				}
				$count = 0;
			}
		}
	}

	foreach ($form_data as $key => $value) {
		setcookie($key, $value, time()+3600);
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
		if ($message) echo "<div class=\"message\">$message</div>";
	?>	
	<?php 
		if ($count) {
	?>
	<form method="POST" action="<?php echo "?id=".htmlspecialchars($_GET["id"])."&count=".htmlspecialchars($_GET["count"]);?>">
		<?php
			for ($i = 0; $i < $count; $i++) {
		?>
				<fieldset>
					<legend>Putnik <?php echo $i + 1; ?></legend>
					Ime i prezime: <input type="text" name="name<?php echo "[$i]"; ?>" value="<?php echo isset($form_data["name".$i]) ? $form_data["name".$i] : ""; ?>"/>
					Broj pasoša: <input type="text" name="passport<?php echo "[$i]"; ?>"  value="<?php echo isset($form_data["passport".$i]) ? $form_data["passport".$i] : ""; ?>"/>
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