<?php

class Reservation
{
    private $movie;
    private $seat;
    private $name;
    private $phone;
    private $email;

    public function __construct($movie, $seat, $name, $phone, $email)
    {
        $this->movie = $movie;
        $this->seat = $seat;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function getMovie()
    {
        return $this->movie;
    }

    public function getSeat()
    {
        return $this->seat;
    }

    public function getSeatRow()
    {
    	$seat_exploded = explode("-", $this->seat);
		if (count($seat_exploded) == 2) {
			return $seat_exploded[0];
		} else {
			return "-";
		}
    }

    public function getSeatColumn()
    {
    	$seat_exploded = explode("-", $this->seat);
		if (count($seat_exploded) == 2) {
			return $seat_exploded[1];
		} else {
			return "-";
		}
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getHtml()
    {
    	return  "<h2>Rezervacija za film {$this->movie->getTitle()}, red {$this->getSeatRow()}, kolona {$this->getSeatColumn()}</h2>
				<p>Ime: <b>".htmlspecialchars($this->name)."</b></p>
				<p>Telefon: <b>".htmlspecialchars($this->phone)."</b></p>
				<p>Email: <b>".htmlspecialchars($this->email)."</b></p>";
    }
}