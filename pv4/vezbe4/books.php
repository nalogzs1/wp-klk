<?php
  $json = file_get_contents("books.json");
  $data = json_decode($json, true);
  $books = $data["content"]["books"];
  
  $booksHtmls = array("p" => array(), // HTML-ovi knjiga pozitivne recenzije
                      "n" => array(), // HTML-ovi knjiga negativne recenzije
                      "a" => array()); // HTML-ovi svih knjiga
?>

<!DOCTYPE html>
<html>
<head>
	<title>Books</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<h1>Kirkus reviews</h1>
</body>
</html>