<?php
require_once("config.php");
require_once("classes/Movie.php");
require_once("classes/Reservation.php");

class DBUtils {
    
    const SEATS_ROWS = 10;
    const SEATS_COLS = 15;

    public static function initDB()
    {
        $db = new SQLite3(DB_NAME);
        $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='" . TBL_MOVIE . "';");
        if (!$tables->fetchArray()) {
            $db->exec("CREATE TABLE IF NOT EXISTS " . TBL_MOVIE . " (" . COL_MOVIE_ID . " integer PRIMARY KEY AUTOINCREMENT, " . COL_MOVIE_NAME . " text);");
            $db->exec("CREATE TABLE IF NOT EXISTS " . TBL_RESERVATION . " (" . COL_RES_MOVIE . " integer, " . COL_RES_SEAT . " text, " . COL_RES_NAME . " text, " . COL_RES_PHONE . " text, " . COL_RES_EMAIL . " text, FOREIGN KEY(" . COL_RES_MOVIE . ") REFERENCES " . TBL_MOVIE . "(" . COL_MOVIE_ID . "));");
            $db->exec("INSERT INTO " . TBL_MOVIE . " (" . COL_MOVIE_NAME . ") VALUES ('The Justice League'), ('Les as de la jungle'), ('Happy Family'), ('The LEGO Ninjago'), ('Despicable Me 3');");
        }
        $db->close();
    }

    public static function getMovies()
    {
        $db = new SQLite3(DB_NAME);
        $movies = $db->query("SELECT * FROM " . TBL_MOVIE);
        $result = array();
        while ($row = $movies->fetchArray(SQLITE3_ASSOC))
            $result[] = new Movie($row[COL_MOVIE_ID], $row[COL_MOVIE_NAME]);
        $db->close();
        return $result;
    }

    public static function getSeatsAvailability($movie)
    {
        $db = new SQLite3(DB_NAME);
        $reservations = $db->query("SELECT * FROM " . TBL_RESERVATION . " WHERE " . COL_RES_MOVIE . "='$movie'");
        $result = array();
        for ($i = 0; $i < self::SEATS_ROWS; $i++) {
            $result[$i] = array();
            for ($j = 0; $j < self::SEATS_COLS; $j++) {
                $result[$i][$j] = true;
            }
        }
        while ($row = $reservations->fetchArray(SQLITE3_ASSOC)) {
            $seat = explode("-", $row[COL_RES_SEAT]);
            $result[$seat[0]][$seat[1]] = false;
        }
        $db->close();
        return $result;
    }

    public static function makeReservation($reservation)
    {
        $db = new SQLite3(DB_NAME);
        if (!$db->query("SELECT * FROM " . TBL_RESERVATION . " WHERE " . COL_RES_MOVIE . "='{$reservation->getMovie()->getId()}' AND " . COL_RES_SEAT . "='{$reservation->getSeat()}'")->fetchArray()) {
            $success = $db->exec("INSERT INTO " . TBL_RESERVATION . " (" . COL_RES_MOVIE . ", " . COL_RES_SEAT . " , " . COL_RES_NAME . " , " . COL_RES_PHONE . " , " . COL_RES_EMAIL . ") VALUES ('{$reservation->getMovie()->getId()}', '{$reservation->getSeat()}', '{$reservation->getName()}', '{$reservation->getPhone()}', '{$reservation->getEmail()}');");
        } else {
            $success = false;
        }
        $db->close();
        return $success;
    }

    public static function getReservation($movie, $seat)
    {
        $db = new SQLite3(DB_NAME);
        $result = $db->query("SELECT * FROM " . TBL_RESERVATION . " WHERE " . COL_RES_MOVIE . "=$movie AND " . COL_RES_SEAT . "='$seat'")->fetchArray(SQLITE3_ASSOC);
        $reservation = null;
        if ($result) {
            $movie = self::getMovieById($movie);
            $reservation = new Reservation($movie, $seat, $result[COL_RES_NAME], $result[COL_RES_PHONE], $result[COL_RES_EMAIL]);
        }
        $db->close();
        return $reservation;
    }

    public static function getMovieById($id)
    {
        $db = new SQLite3(DB_NAME);
        $result = $db->query("SELECT * FROM " . TBL_MOVIE . " WHERE " . COL_MOVIE_ID . "='$id'")->fetchArray(SQLITE3_ASSOC);
        $movie = new Movie($result[COL_MOVIE_ID], $result[COL_MOVIE_NAME]);
        $db->close();
        return $movie;
    }
}