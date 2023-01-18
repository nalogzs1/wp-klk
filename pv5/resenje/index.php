<?php
    $songs = array();

    function load($fname){
        global $songs;

        $json = file_get_contents($fname);
        $songs = json_decode($json, true);
    }

    function play($song_name) {
        global $songs;

        return $songs[$song_name];
    }

    if (isset($_GET["song"])) {
        play($_GET["song"]);
    }

    if(isset($_GET["playlist"])) {
        load(".\playlists\\".$_GET["playlist"]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlist</title>
</head>
<style>
    body {
        background-image: url('background.jpg');
        text-align: center;
    }

    div {
        display: inline-block;
    }

    .pl-select {
        font-family: cursive, sans-serif;
        background-color: #99e6ff;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 2px 2px 10px 13px #ccf2ff;
    }

    .song-select{
        font-family: cursive, sans-serif;
        background-color: #ff99ff;
        padding: 10px;
        border-radius: 4px;
        box-shadow: 2px 2px 10px 13px #ffccff;
    }
    select {
        background-color: white;
        border: thin solid blue;
        border-radius: 2px;
        display: inline-block;
        font: inherit;
    }
</style>
<body>
    <div class="pl-select">
        <p>Select playlist</p>
        <form action="">
            <select name="playlist">
            <?php
                $path = dirname(__FILE__).'\playlists';
                $files = scandir($path);
                foreach($files as $file){
                    if($file != '.' && $file != '..'){
                        $fname = explode(".", $file)[0];
                        echo "<option value=\"$file\">$fname</option>";
                    }
                }
            ?>
            </select>
            <input type="submit"/>
        </form>
    </div>
    <br>
    <br>
    <br>
    <?php
        if(isset($_GET["playlist"])) {
            echo "<div class=\"song-select\">";
            echo "<p>Select song</p>";
            echo "<form action = \"\">";
            echo "<select name=\"song\">";
            foreach ($songs as $title => $url) {
                echo "<option value=\"$title\">$title</option>";
            }
            echo "</select>";
            echo "<input type=\"hidden\" name=\"playlist\" value=\"{$_GET["playlist"]}\"/>";
            echo "<input type=\"submit\">";
            echo "</form>";
            echo "</div>";
        }

        if(isset($_GET["song"])){
            $url = play($_GET["song"]);
            echo "<h3>{$_GET["song"]}</h3>";
            echo "<iframe width=\"420\" height=\"315\" src=\"$url?autoplay=1\"></iframe>";
        }
    ?>
</body>
</html>