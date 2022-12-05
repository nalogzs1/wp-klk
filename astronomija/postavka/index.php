<?php
	require_once("classes/Picture.php");

	function loadPictures() {
		$json = file_get_contents("data.json");
		$data = json_decode($json, true);
		// TODO 1.4
	}

	$date = date("Y-m-d", time());
	$pictures = loadPictures();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Astronomy Pictures of the Day</title>
	<link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Amatic+SC|Josefin+Slab|Jura&display=swap" rel="stylesheet">
	<meta charset="utf-8">
</head>
<body>
	<div>		
		<a href="."><h1>Astronomy Picture of the Day</h1></a>
        <h6>by NASA</h6>

		<!-- TODO 3 - Mesto za formu -->

		<!-- TODO 5 - Mesto za formu -->

		<div class="container">
			<!-- TODO 2 -->

			<!-- TODO 4 -->
		</div>
	</div>
</body>
</html>
