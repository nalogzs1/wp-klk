<?php

class Predmet
{
    private $vreme;
    private $sala;
    private $naziv;
    private $profesor;
    private $tip;
    private $opis;

    public function __construct($vreme, $sala, $naziv, $profesor, $tip, $opis)
    {
        $this->vreme = $vreme;
        $this->sala = $sala;
        $this->naziv = $naziv;
        $this->profesor = $profesor;
        $this->tip = $tip;
        $this->opis = $opis;
    }

    public function getHtml($dan)
    {
        $html = "";
        $html .= "<tr>";
        $html .= "<td>{$dan}</td>";
        $html .= "<td><a href='opis.php?opis={$this->opis}&naziv={$this->naziv}'>{$this->naziv}</a></td>";
        $html .= "<td>{$this->vreme}</td>";
        $html .= "<td>{$this->profesor}</td>";
        $html .= "<td>{$this->sala}</td>";
        $html .= "<td>{$this->tip}</td>";
        $html .= "</tr>";
        return $html;
    }
}