<?php
    require_once("classes/RankList.php");
    require_once("classes/RankListItem.php");
    require_once("constants.php");

    $json = file_get_contents("data.json");
    $data = json_decode($json, true);

    $max_top_list_count = 0;

    $rank_lists = array();
    foreach ($data as $rank_list_arr) {
        $max_top_list_count = max(count($rank_list_arr[RL_ITEMS]), $max_top_list_count);
        $rank_lists[] = new RankList($rank_list_arr);
    }

    $top_list_count = TOP_LIST_DEFAULT_COUNT;
    if (isset($_GET["list_items"])) {
        $top_list_count = $_GET["list_items"];
    }
?>
<html>
<head>
    <title>Rang liste</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Rang liste</h1>
    <div class="buttons">
        <?php
        $i = 1;
        $next_rounded = 10;
        while ($i <= $max_top_list_count) {
            echo "<a href=\"?list_items=$i\"><button>Top-$i</button></a>";
            if ($i != $next_rounded / 2) {
                $i = $next_rounded / 2;
            } else {
                $i = $next_rounded;
                $next_rounded *= 10;
            }
        }
        ?>
    </div>
    <div class="card-columns">
        <?php
        foreach ($rank_lists as $rank_list) {
            echo $rank_list->getTopListHtml($top_list_count);
        }
        ?>
    </div>
</body>
</html>