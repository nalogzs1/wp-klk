<?php 
    require_once("classes/Score.php");

    function parse($filename) {
        $array_obj = array();
        $file = fopen($filename, "r");
        if ($file) {
            while ($line = fgetcsv($file, 0, ";")) {
                $array_obj[] = new Score($line);
            }
            fclose($file);
        }
        return $array_obj;
    }

    function append($filename, $new_score){
        $file = fopen($filename, "a");
        if ($file) {
            fwrite($file, $new_score->get_csv());
            fclose($file);
        }
    }
?>