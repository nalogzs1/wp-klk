<?php

function pageHeader($naslov, $podnaslov, $style)
{
    echo "<html>";
    echo "<head>";
    echo "<title>Raspored Informatika</title>";
    echo "<meta charset=\"utf-8\">";
    echo "<link rel=\"stylesheet\" href=\"{$style}\"/>";
    echo "</head>";
    echo "<body>";
    echo "<div class=\"naslov\">";
    echo "<h1>{$naslov}</h1> ";
    echo "<h2>{$podnaslov}</h2> ";
    echo "</div> ";

}

function pageFooter($author="Unknown", $mail="Unknown")
{
    echo "<footer>";
    echo "<p>Author: {$author}</p>";
    echo "<p>Contact information: <a href=\"mailto:{$mail}\">{$mail}</a>.</p>";
    echo "</footer>";
    echo "</body>";
    echo "</html>";
}