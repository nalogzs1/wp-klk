<?php
define("DB_NAME", "letovi.db");
define("TBL_FLIGHT", "Flight");
define("COL_FLIGHT_ID", "id");
define("COL_FLIGHT_FROM", "from_airport");
define("COL_FLIGHT_TO", "to_airport");
define("COL_FLIGHT_SEATS", "seats");
define("COL_FLIGHT_DEPARTURE_TIME", "departure_time");
define("COL_FLIGHT_ARRIVAL_TIME", "arrival_time");
define("COL_FLIGHT_PRICE", "price");
define("COL_FLIGHT_AIRLINE", "airline");
define("TBL_RESERVATION", "Reservation");
define("COL_RESERVATION_ID", "id");
define("COL_RESERVATION_FLIGHT", "flight_id");
define("COL_RESERVATION_NAME", "name");
define("COL_RESERVATION_PASSPORT", "passport");
define("TBL_AIRPORT", "Airport");
define("COL_AIRPORT_ID", "id");
define("COL_AIRPORT_NAME", "name");
define("COL_AIRPORT_CITY", "city");
define("MAX_TICKETS", 5);
define("MAX_RECENTS", 3);
?>