<?php

class RankListItem {
    private $name;
    private $points;

    public function __construct($name, $points) {
        $this->name = $name;
        $this->points = $points;
    }

    public function getName() {
        return $this->name;
    }

    public function getPoints() {
        return $this->points;
    }

    public static function getTableHeading() {
        return
        "<tr><th>Rang</th><th>Naziv</th><th>Vrednost</th></tr>";
    }

    public function getHtml($rank) {
        // TODO 1
    }
}

function compareAscending(RankListItem $item1, RankListItem $item2) {
    if ($item1->getPoints() < $item2->getPoints()) {
        return -1;
    } elseif ($item1->getPoints() > $item2->getPoints()) {
        return 1;
    } else {
        return 0;
    }
}

function compareDescending(RankListItem $item1, RankListItem $item2) {
    return compareAscending($item2, $item1);
}