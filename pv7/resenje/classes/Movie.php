<?php

require_once("classes/Movie.php");

class Movie
{
    private $id;
    private $title;

    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getHtml($selected_movie) {
        $html = "<div>";
        $html .= "<h2>{$this->title}</h2>";
        if ($selected_movie == $this->id) {
            $html .= $this->getSeatsAvailabilityHtml();
        } else {
            $html .= "<a href=\"?movie={$this->id}\"><button>Odaberi sedište</button></a>";
        }
        $html .= "</div>";
        return $html;
    }

    public function getSeatsAvailabilityHtml()
    {
    	$availability = DBUtils::getSeatsAvailability($this->getId());
        $html = "<div>";
        foreach ($availability as $row_index => $row_seats) {
            $html .= "<div>";
            foreach ($row_seats as $col_index => $seat) {
                if ($seat)
                    $html .= "<a href=\"reserve.php?movie={$this->getId()}&seat=$row_index-$col_index\"><div class=\"free\"></div></a>";
                else
                    $html .= "<a href=\"details.php?movie={$this->getId()}&seat=$row_index-$col_index\"><div class=\"reserved\"></div></a>";
            }
            $html .= "</div>";
        }
        $html .= "</div>";
        return $html;
    }
}