<?php
###Mesto za Header###
?>
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
        $json = file_get_contents("data.json");
        $data = json_decode($json, true);
        ###Mesto za prikaz predmeta###
        ?>
    </table>
</div>
<?php
    ###Mesto za Footer###
?>