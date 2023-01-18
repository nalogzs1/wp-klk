<?php

class Dan
{
    private $naziv;
    private $predmeti;

    public function __construct($naziv)
    {
        $this->naziv = $naziv;
        $this->predmeti = array();
    }

    public function dodajPredmet($p)
    {
        if (is_a($p, "Predmet"))
            $this->predmeti[] = $p;
    }

    function getNaziv()
    {
        return $this->naziv;
    }

    function getPredmeti()
    {
        return $this->predmeti;
    }

}