<?php
require_once "classes/Utils.php";
require_once "parts.php";

$dani = Utils::ucitaj();

$izabrani_dan = "";
if (isset($_POST["dan"])) {
    $izabrani_dan = $_POST["dan"];
}

pageHeader("Raspored predavanja - I godina", "modul: Informacione tehnologije", "css/style.css");

?>

<form method="post">
    <select name="dan">
        <option value="">-</option>
        <?php
            foreach ($dani as $dan) {
                $name = $dan->getNaziv();
                $selected = $izabrani_dan == $name ? "selected" : "";
                echo "<option value=\"$name\" $selected>$name</option>";
            }
        ?>
    </select>
    <input type="submit" value="Odaberi">
</form>

<div>
    <table>
        <tr>
            <th>Dan</th>
            <th>Naziv</th>
            <th>Vreme</th>
            <th>Profesor</th>
            <th>Sala</th>
            <th>Tip</th>
        </tr>
        <?php
        foreach ($dani as $dan)
        {
            $naziv = $dan->getNaziv();
            if (!empty($izabrani_dan) && $naziv != $izabrani_dan) continue;
            foreach ($dan->getPredmeti() as $predmet)
            {
                echo $predmet->getHtml($naziv);
            }
        }
        ?>
    </table>
</div>
<?php
pageFooter("Ime Prezime", "mail.example.com");
?>