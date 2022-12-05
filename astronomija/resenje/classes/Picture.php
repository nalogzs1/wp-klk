<?php

class Picture {
    private $title;
    private $copyright;
    private $date;
    private $explanation;
    private $hdurl;
    private $url;

    function __construct($data) {
        $this->title = $data["title"];
        if (isset($data["copyright"])) {
            $this->copyright = $data["copyright"];
        }
        $this->date = $data["date"];
        $this->explanation = $data["explanation"];
        $this->hdurl = $data["hdurl"];
        $this->url = $data["url"];
    }

    function getBriefHtml() {
        return "
            <a href=\"?date={$this->date}\">
                <div class=\"apod brief\">
                    <img src=\"{$this->url}\">
                    <span>{$this->title}</span>
                </div>
            </a>
        ";
    }

    function getHtml($hd) {
        $img_url = $hd ? $this->hdurl : $this->url;
        $copyright = empty($this->copyright) ? "" : "<span class=\"copyright\">{$this->copyright}</span>";
        return "
            <div class=\"apod\">
                <h3>{$this->title}</h3>
                <h4>{$this->date}</h4>
                <div>
                    <img src=\"$img_url\">
                    $copyright
                </div>
                <p>{$this->explanation}</p>
            </div>
        ";
    }
}