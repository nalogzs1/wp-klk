<?php
    require_once("parser.php");
    require_once("classes/Score.php");

    $filename = "";

    //TODO 2

    if (isset($_GET["filename"])) {
        $filename = "files/" . $_GET["filename"];
        if (!file_exists($filename)) {
            redirect();
        }
    }

    //TODO 5

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
                //TODO 4
            ?>
        </table>
    </div>

    <form method="POST" class="container">
        <!-- TODO 5 -->
    </form>
    <?php } ?>
</body>
</html>