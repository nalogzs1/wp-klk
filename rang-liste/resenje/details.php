<?php
    require_once("classes/RankList.php");

    if (!isset($_GET["name"])) {
        header("Location: index.php");
        die();
    }

    $name = $_GET["name"];

    $json = file_get_contents("data.json");
    $data = json_decode($json, true);

    $rank_list = null;

    foreach ($data as $rank_list_arr) {
        if ($name == $rank_list_arr[RL_NAME]) {
            $rank_list = new RankList($rank_list_arr);
            break;
        }
    }

    if ($rank_list == null) {
        header("Location: index.php");
        die();
    }
?>
<html>
<head>
    <title><?php echo $rank_list->getName(); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1><?php echo $rank_list->getName(); ?></h1>
    <a href="./" style="float: right; margin: 10px;"><img style="width: 50px;" src="images/home.png"></a>
    <form method="post">
        <input type="text" name="search">
        <input type="submit">
    </form>
    <?php
        if (isset($_POST["search"])) {
            $search = $_POST["search"];
            $rank = $rank_list->getRank($search);
            echo "<p>";
            if ($rank < 0) {
                echo "Naziv $search ne postoji u ovoj rang listi.";
            } else {
                echo "$search ima rang $rank.";
            }
            echo "</p>";
        }
        echo $rank_list->getListTableHtml();
    ?>
</body>
</html>