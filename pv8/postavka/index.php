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
	
	$flights = array();
	if (isset($_GET["pretraga"])) {
		$from = $_GET["od"];
		$to = $_GET["do"];
		$passengers = $_GET["broj_putnika"];
		$flights = getFlights($from, $to);
		// TODO 1: Ubaciti pretraživani let u sesiju.
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
	<!-- TODO 1: Prikazati poslednje pretraživane letove. -->
	<form>
		<!-- TODO 2: Modifikovati kod ispod, tako da se u formi prikazuju podaci poslednje unete pretrage. -->
		Od: <?php outputAirportsSelect("od", "");?>
		Do: <?php outputAirportsSelect("do", "");?>
		Broj putnika: <input type="number" name="broj_putnika" min="1" max="<?php echo MAX_TICKETS; ?>"/>
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