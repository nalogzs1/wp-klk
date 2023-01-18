<?php
    require_once("parser.php");
    require_once("classes/Score.php");

    $filename = "";

    if (isset($_POST["submit-file"])) {
        if(isset($_FILES["results"]) && is_uploaded_file($_FILES["results"]["tmp_name"])) {
            processForm();
            $filename = "files/" . basename($_FILES["results"]["name"]);
        } else {
            redirect();
        }
    }

    if (isset($_GET["filename"])) {
        $filename = "files/" . $_GET["filename"];
        if (!file_exists($filename)) {
            redirect();
        }
    }

    if (isset($_POST["newscore"])) {
        $filename = $_POST["filename"];
        $line = array($_POST["player1"], $_POST["player2"], $_POST["resultP1"], $_POST["resultP2"]);
        $newscore = new Score($line);
        append($filename, $newscore);
    }

    if (!isset($_POST["submit-file"]) && !isset($_GET["filename"]) && !isset($_POST["newscore"])) {
        redirect();
    }

    function processForm() {
        global $message;

        if ($_FILES["results"]["error"] == UPLOAD_ERR_OK ) {
            if (!move_uploaded_file($_FILES["results"]["tmp_name"], "files/" . basename( $_FILES["results"]["name"]))) {
                $message = "Sorry, there was a problem uploading that file.";
            }
        } else {
            switch( $_FILES["results"]["error"] ) {
                case UPLOAD_ERR_INI_SIZE:
                    $m = "The file is larger than the server allows.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $m = "The file is larger than the script allows.";
                    break;
                default:
                    $m = "Please contact your server administrator for help.";
            }
            $message = "Sorry, there was a problem uploading that file. $m";
        }
    }

    function redirect() {
        echo("<script>
                alert(\"Please upload or select a file...\");
                window.location.replace(\"./\");
            </script>");
    }
      
?>
<html>
<head>
    <title>Player score</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <a href="."><button>HOME</button></a>
        
    <?php
    if (isset($message)) {
        echo "<div class=\"container error\">$message</div>";
    } else {
    ?>
    <div class="container">
        <table>
            <?php
                $scores = parse($filename);
                foreach ($scores as $score) {
                    echo $score->get_html();
                }
            ?>
        </table>
    </div>

    <form method="POST" class="container" action="?filename=<?php echo basename($filename); ?>">
        <h5>Enter new score</h5>
        <div>
            Player 1: <input type="text" name="player1"/>
            Player 2: <input type="text" name="player2"/>
        </div>
        <div>
            Player 1 score: <input type="number" name="resultP1" min="1" max="10" step="1"/>
            Player 2 score: <input type="number" name="resultP2" min="1" max="10" step="1"/>
        </div>
        <input type="hidden" name="filename" value="<?php echo $filename;?>"/>
        <input type="submit" name="newscore" value="Save score"/>
    </form>
    <?php } ?>
</body>
</html>