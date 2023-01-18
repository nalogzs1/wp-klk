<?php
require_once("config.php");

function initDB()
{
    $db = new SQLite3(DB_NAME);
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='" . TBL_FLIGHT . "';");
	if (!$tables->fetchArray()) {
		$db->exec("CREATE TABLE IF NOT EXISTS " . TBL_AIRPORT . " (" . COL_AIRPORT_ID . " text, " . COL_AIRPORT_NAME . " text, ". COL_AIRPORT_CITY." text);");
		
		$db->exec("CREATE TABLE IF NOT EXISTS " . TBL_FLIGHT . " (" . COL_FLIGHT_ID . " integer PRIMARY KEY AUTOINCREMENT, " . COL_FLIGHT_FROM . " text, " . COL_FLIGHT_TO . " text, " . COL_FLIGHT_SEATS . " integer, " . COL_FLIGHT_DEPARTURE_TIME . " text, " . COL_FLIGHT_ARRIVAL_TIME . " text, " . COL_FLIGHT_PRICE . " integer, " . COL_FLIGHT_AIRLINE . " text, FOREIGN KEY(".COL_FLIGHT_FROM.") REFERENCES ".TBL_AIRPORT."(".COL_AIRPORT_ID."), FOREIGN KEY(".COL_FLIGHT_TO.") REFERENCES ".TBL_AIRPORT."(".COL_AIRPORT_ID."));");

        $db->exec("CREATE TABLE IF NOT EXISTS " . TBL_RESERVATION . " (" . COL_RESERVATION_ID . " integer PRIMARY KEY AUTOINCREMENT," . COL_RESERVATION_NAME . " text, " . COL_RESERVATION_PASSPORT . " text, ".COL_RESERVATION_FLIGHT." integer, FOREIGN KEY(".COL_RESERVATION_FLIGHT.") REFERENCES ".TBL_FLIGHT."(".COL_FLIGHT_ID."));");
        
        $json = file_get_contents("airports.json");
        $array = json_decode($json, true);
        foreach ($array as $item) {
            $db->exec("INSERT INTO " . TBL_AIRPORT . " (" . COL_AIRPORT_ID . "," . COL_AIRPORT_NAME . "," . COL_AIRPORT_CITY . ") VALUES ('{$item[COL_AIRPORT_ID]}','{$item[COL_AIRPORT_NAME]}','{$item[COL_AIRPORT_CITY]}');");
        }        

        $json = file_get_contents("flights.json");
        $array = json_decode($json, true);
        foreach ($array as $item) {
            $db->exec("INSERT INTO " . TBL_FLIGHT . " (" . COL_FLIGHT_FROM . "," . COL_FLIGHT_TO . "," . COL_FLIGHT_SEATS . "," . COL_FLIGHT_DEPARTURE_TIME . "," . COL_FLIGHT_ARRIVAL_TIME . "," . COL_FLIGHT_PRICE . ",". COL_FLIGHT_AIRLINE .") VALUES ('{$item[COL_FLIGHT_FROM]}','{$item[COL_FLIGHT_TO]}','{$item[COL_FLIGHT_SEATS]}','{$item[COL_FLIGHT_DEPARTURE_TIME]}','{$item[COL_FLIGHT_ARRIVAL_TIME]}','{$item[COL_FLIGHT_PRICE]}','{$item[COL_FLIGHT_AIRLINE]}');");
        }
    }
    $db->close();
}

function getAirports()
{
    $db = new SQLite3(DB_NAME);
    $airports = $db->query("SELECT * FROM " . TBL_AIRPORT);
    $result = array();
    while ($row = $airports->fetchArray(SQLITE3_ASSOC))
        $result[] = $row;
    $db->close();
    return $result;
}

function getFlight($id) {
	$db = new SQLite3(DB_NAME);
    $flights = $db->query("SELECT * FROM " . TBL_FLIGHT . " where " . COL_FLIGHT_ID . " = '$id'");
    $result = $flights->fetchArray(SQLITE3_ASSOC);
    $db->close();
    return $result;
}

function getFlights($from, $to) {
    $db = new SQLite3(DB_NAME);
    $flights = $db->query("SELECT * FROM " . TBL_FLIGHT . " WHERE " . COL_FLIGHT_FROM . "='$from' AND " . COL_FLIGHT_TO . "='$to' order by " . COL_FLIGHT_DEPARTURE_TIME);
    $result = array();
    while ($row = $flights->fetchArray(SQLITE3_ASSOC))
        $result[] = $row;
    $db->close();
    return $result;
}

function getReservations() {
    $db = new SQLite3(DB_NAME);
    $reservations = $db->query("SELECT * FROM " . TBL_RESERVATION . " order by " . COL_RESERVATION_ID);
    $result = array();
    while ($row = $reservations->fetchArray(SQLITE3_ASSOC))
        $result[] = $row;
    $db->close();
    return $result;
}

function makeReservation($flight, $name, $passport) {
	if (getAvailableSeatsCount($flight) <= 0) return false;
	$db = new SQLite3(DB_NAME);
    $db->exec("INSERT INTO " . TBL_RESERVATION . " (" . COL_RESERVATION_FLIGHT . "," . COL_RESERVATION_NAME . "," . COL_RESERVATION_PASSPORT.") VALUES ('$flight','$name','$passport');");
    $db->close();
    return true;
}

function getAvailableSeatsCount($flight) {
	$db = new SQLite3(DB_NAME);
    $reservations = $db->query("SELECT * FROM " . TBL_RESERVATION . " WHERE " . COL_RESERVATION_FLIGHT . "=$flight");
    $count = 0;
    while ($row = $reservations->fetchArray(SQLITE3_ASSOC))
        $count++;
    $db->close();
    $flight = getFlight($flight);
    return $flight[COL_FLIGHT_SEATS] - $count;
}