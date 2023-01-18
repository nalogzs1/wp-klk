<?php
  $filterKey = "a";
  if (isset($_GET["filter"])) {
    $filterKey = $_GET["filter"];
    if (!in_array($filterKey, ["a", "p", "n"])) {
      $filterKey = "a";
    }
  }

  $json = file_get_contents("books.json");
  $data = json_decode($json, true);

  $books = $data["content"]["books"];
  
  $booksHtmls = array("p" => array(), // HTML-ovi knjiga pozitivne recenzije
                      "n" => array(), // HTML-ovi knjiga negativne recenzije
                      "a" => array()); // HTML-ovi svih knjiga

  foreach($books as $bookInfo) {
    if ($bookInfo["rating"] >= 3) {
      $ratingClass = "positive";
      $positive = true;
    } else {
      $ratingClass = "negative";
      $positive = false;
    }
    $stars = $bookInfo["rating"] > 1 ? "Stars" : "Star";
    $bookHtml = 
"<div class=\"container\">
<div class=\"book-detail\">
  <img src=\"images/{$bookInfo["img"]}\"></img>
  <h3>{$bookInfo["title"]}</h3>
  <p>{$bookInfo["summary"]}</p>
</div>
<div class=\"book-review\">
  <h3 class=\"$ratingClass\">{$bookInfo["rating"]} $stars</h3>
  <p>{$bookInfo["review"]}</p>
</div>
</div>";
    $booksHtmls["a"][] = $bookHtml;
    $booksHtmls[$positive ? "p" : "n"][] = $bookHtml;
  }
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
  <a href="?filter=a"><button>Show All (<?php echo count($booksHtmls["a"]);?>)</button></a>
	<a href="?filter=p"><button>Show Positive (<?php echo count($booksHtmls["p"]);?>)</button></a>
  <a href="?filter=n"><button>Show Negative (<?php echo count($booksHtmls["n"]);?>)</button></a>
  <?php
    foreach($booksHtmls[$filterKey] as $bookInfo) {
      echo $bookInfo;
    }
  ?>
</body>
</html>