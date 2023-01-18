<?php
    function getFiles() {
        $files = array();
        if (!file_exists("files")) {
            mkdir("files", 0777);
        }
        $directory = opendir("files");
        if ($directory) {
            while (($filename = readdir($directory)) !== false) {
                if ($filename == "." || $filename == "..") continue;
                $files[] = $filename;
            }
        }
        closedir($directory);
        return $files;
    }
?>

<html>
<head>
    <title>Player score</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <img src="images/title.png" width="500px">
    <form method="POST" enctype="multipart/form-data" action="results.php" class="container">
        <label for="results">Upload a file:</label>
        <input type="file" name="results" id="results" accept=".csv"/>
        <input type="submit" name="submit-file" value="Analize"/>
    </form>

    <div class="container">
        <h5>Previously loaded files:</h5>
        <?php
            foreach (getFiles() as $filename) {
                echo "<a href=\"results.php?filename=$filename\">$filename</a><br>";
            }
        ?>
    </div>
</body>
</html>