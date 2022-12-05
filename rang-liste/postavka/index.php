<?php
    require_once("classes/RankList.php");
    require_once("classes/RankListItem.php");
    require_once("constants.php");

    $json = file_get_contents("data.json");
    $data = json_decode($json, true);

    $rank_lists = array();
    foreach ($data as $rank_list_arr) {
        $rank_lists[] = new RankList($rank_list_arr);
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
        <!-- TODO 4 -->
    </div>
    <div class="card-columns">
        <!-- TODO 3 -->
    </div>
</body>
</html>