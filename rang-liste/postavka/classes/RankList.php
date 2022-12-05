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
        // TODO 2
    }

    public function getRank($name) {
        // TODO 5.1
    }
}