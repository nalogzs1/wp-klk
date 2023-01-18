<?php
require_once "classes/Dan.php";
require_once "classes/Predmet.php";

class Utils
{
    public static function ucitaj()
    {
        $json = file_get_contents("data.json");
        $data = json_decode($json, true);
        $dani = array();
        foreach ($data["Dani"] as $dan) {
            $danObj = new Dan($dan["Dan"]);
            foreach ($dan ["Predmeti"] as $predmet) {
                $naziv = $predmet["Predmet"];
                $vreme = $predmet["Vreme"];
                $profesor = $predmet["Nastavnik"];
                $sala = $predmet["Sala"];
                $tip = $predmet["Tip"];
                $opis = $predmet["Opis"];
                $predmet = new Predmet($vreme, $sala, $naziv, $profesor, $tip, $opis);
                $danObj->dodajPredmet($predmet);
            }
            $dani[] = $danObj;
        }
        return $dani;
    }
}