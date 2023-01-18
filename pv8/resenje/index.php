<?php
	require_once("config.php");
	require_once("database_utils.php");

	function outputAirportsSelect($name, $default_value) {
		echo "<select name=$name>";
		$airports = getAirports();
		foreach ($airports as $airport) {
			$selected = $airport[COL_AIRPORT_ID] == $default_value ? "selected" : "";
			echo "<option value={$airport[COL_AIRPORT_ID]} $selected>{$airport[COL_AIRPORT_CITY]} ({$airport[COL_AIRPORT_NAME]})</option>";
		}
		echo "</select>";
	}

	initDB();
	session_start();
	$flights = array();
	if (isset($_GET["pretraga"])) {
		$from = htmlspecialchars($_GET["od"]);
		$to = htmlspecialchars($_GET["do"]);
		$passengers = htmlspecialchars($_GET["broj_putnika"]);
		$flights = getFlights($from, $to);
		if (!isset($_SESSION["recent"])) {
			$_SESSION["recent"] = array();
		}
		$_SESSION["recent"][] = array("od" => $from, "do" => $to, "broj_putnika" => $passengers);
		if (count($_SESSION["recent"]) > MAX_RECENTS) {
			array_shift($_SESSION["recent"]);
		}
	}

	$from_init = "";
	$to_init = "";
	$passengers_init = 1;
	if (isset($_SESSION["recent"]) && !empty($_SESSION["recent"])) {
		$last_input = end($_SESSION["recent"]);
		$from_init = $last_input["od"];
		$to_init = $last_input["do"];
		$passengers_init = $last_input["broj_putnika"];
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Avionske karte</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1>Avionske karte</h1>
	<?php 
		if (isset($_SESSION["recent"])) {
			foreach($_SESSION["recent"] as $recent) {
				echo "<a href=\"?pretraga&od=$recent[od]&do=$recent[do]&broj_putnika=$recent[broj_putnika]\">$recent[od]-$recent[do] ($recent[broj_putnika])</a> ";
			}
		}		
	?>
	<form>
		Od: <?php outputAirportsSelect("od", $from_init);?>
		Do: <?php outputAirportsSelect("do", $to_init);?>
		Broj putnika: <input type="number" name="broj_putnika" value="<?php echo $passengers_init;?>" min="1" max="<?php echo MAX_TICKETS; ?>"/>
		<input type="submit" value="Traži" name="pretraga"/>
	</form>
	<h2>
	<?php
		if (empty($flights)) {
			echo "Nema letova za prikaz.";
		} else {
			echo "Letovi sa aerodroma $from do aerodroma $to (broj putnika: $passengers)";
		}
	?>
	</h2>
	<?php
		foreach($flights as $flight) {
			$availableSeats = getAvailableSeatsCount($flight[COL_FLIGHT_ID]);
	?>
			<div class="flight">
				<table>
					<tr>
						<td>Avio kompanija</td>
						<td><?php echo $flight[COL_FLIGHT_AIRLINE];?></td>
					</tr>
					<tr>
						<td>Vreme polaska</td>
						<td><?php echo $flight[COL_FLIGHT_DEPARTURE_TIME];?></td>
					</tr>
					<tr>
						<td>Vreme dolaska</td>
						<td><?php echo $flight[COL_FLIGHT_ARRIVAL_TIME];?></td>
					</tr>
					<tr>
						<td>Cena</td>
						<td><?php echo $flight[COL_FLIGHT_PRICE];?> evra</td>
					</tr>
					<tr>
						<td>Broj slobodnih mesta</td>
						<td><?php echo $availableSeats;?></td>
					</tr>
				</table>
				<?php
					if ($availableSeats >= $passengers) {
				?>
						<a href="reserve.php?<?php echo "id=".$flight[COL_FLIGHT_ID]."&count=".$passengers;?>"><button>Rezerviši</button></a>
				<?php 
					}
				?>
			</div>
	<?php
		}
	?>
</body>
</html>