<?php
    require_once("DBUtils.php");

    DBUtils::initDB();

    $selected_movie = "";
    if (isset($_GET["movie"])) {
        $selected_movie = $_GET["movie"];
    }

    $movies = DBUtils::getMovies();
?>
<html>
<head>
    <title>Bioskop</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Spectral+SC" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <h1>Repertoar bioskopa</h1>

    <div class="movies">
        <?php
        foreach ($movies as $movie) {
            echo $movie->getHtml($selected_movie);
        }
        ?>
    </div>
</body>
</html>