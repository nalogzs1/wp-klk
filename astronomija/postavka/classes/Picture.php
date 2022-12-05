<?php

class Picture {
    private $title;
    private $copyright;
    private $date;
    private $explanation;
    private $hdurl;
    private $url;

    // TODO 1.1

    function getBriefHtml() {
        return "
            <div class=\"apod brief\">
                <img src=\"{$this->url}\">
                <span>{$this->title}</span>
            </div>
        ";
    }

    // TODO 1.2
}