<?php
	require_once("config.php");
	require_once("database_utils.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Avionske karte</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style>
		body {
			text-align: center;
		}

		table {
			margin: auto;
		}

		td {
			padding: 4px 10px;
		}
	</style>
</head>
<body>
	<h1>Rezervacije</h1>
	<table>
		<tr>
			<td>ID Rezervacije</td>
			<td>Let</td>
			<td>Ime i prezime</td>
			<td>Pasoš</td>
		</tr>
	<?php
	foreach(getReservations() as $reservation) {
		$flight = getFlight($reservation[COL_RESERVATION_FLIGHT]);
	?>
		<tr>
			<td><?php echo $reservation[COL_RESERVATION_ID];?></td>
			<td><?php echo $flight[COL_FLIGHT_FROM]."-".$flight[COL_FLIGHT_TO]."(Dep: ".$flight[COL_FLIGHT_DEPARTURE_TIME].", Arr: ".$flight[COL_FLIGHT_ARRIVAL_TIME].")";?></td>
			<td><?php echo $reservation[COL_RESERVATION_NAME];?></td>
			<td><?php echo $reservation[COL_RESERVATION_PASSPORT];?></td>
		</tr>
	<?php
	}
	?>
	</table>
</body>
</html>