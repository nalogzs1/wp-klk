<?php

require_once "classes/Utils.php";
require_once "parts.php";

$naziv = "";
if (isset($_GET["naziv"]))
    $naziv = $_GET["naziv"];
$opis = "";
if (isset($_GET["opis"]))
    $opis = $_GET["opis"];

pageHeader("Opis predmeta", "Naziv predmeta: " . $naziv, "css/opis.css");

?>

<div class="naslov">
<?php
    if ($opis != "") {
        echo "<h3>" . $opis . "</h3>";
    } else {
        echo "<h1> Trenutno nema podataka o predmetu. </h1>";
    }
?>
</div>

<?php pageFooter("Ime Prezime", "mail.example.com"); ?>
