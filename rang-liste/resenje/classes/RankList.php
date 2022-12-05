<?php

require_once("classes/RankListItem.php");
require_once("constants.php");

class RankList {
    private $name;
    private $type;
    private $dsc;
    private $items;
    
    public function __construct($data) {
        $this->name = $data[RL_NAME];
        $this->type = $data[RL_TYPE];
        $this->dsc = $data[RL_DSC];
        $this->items = array();
        foreach ($data[RL_ITEMS] as $rank_list_item_arr) {
            $this->items[] = new RankListItem($rank_list_item_arr[RLI_NAME], $rank_list_item_arr[RLI_POINTS]);
        }
        $comparison = $this->dsc ? "compareDescending" : "compareAscending";
        usort($this->items, $comparison);
    }

    public function getName() {
        return $this->name;
    }
    
    public function getTopListHtml($count) {
        return "<a href=\"details.php?name={$this->name}\">
                    <div class=\"card text-white {$this->getTypeClass()}\">
                        <div class=\"card-body\">            
                            <h4 class=\"card-title\">{$this->name}</h4>
                            <div class=\"card-text\">
                            {$this->getListTableHtml($count)}    
                            </div>
                        </div>
                    </div>
                </a>";
    }

    public function getListTableHtml($count = null) {
        if ($count == null)
            $count = count($this->items);
        $str = "<table class=\"table {$this->getTypeClass()}\">";
        $str .= RankListItem::getTableHeading();
        $i = 1;
        foreach ($this->items as $item) {
            $str .= $item->getHtml($i);
            if ($i++ == $count) break;
        }
        $str .= "</table>";
        return $str;
    }

    public function getRank($name) {
        $rank = 1;
        foreach($this->items as $item) {
            if (strpos(strtolower($item->getName()), strtolower($name)) !== false) {
                return $rank;
            }
            $rank++;
        }
        return -1;
    }

    private function getTypeClass() {
        switch ($this->type) {
            case RL_TYPE_MUSIC:
                return "music";
            case RL_TYPE_MOVIES:
                return "movies";
            case RL_TYPE_SPORTS:
                return "sports";
            case RL_TYPE_OTHER:
                return "other";
        }
        return "";
    }
}