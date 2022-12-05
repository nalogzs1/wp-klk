<?php
	require_once("classes/Picture.php");

	// Ovaj metod se lako moze prepraviti tako da direktno poziva API kog je obezbedila NASA.
	// URL za dobavljanje podataka je: https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY&date=YYYY-MM-DD
	function loadPictures() {
		$json = file_get_contents("data.json");
		$data = json_decode($json, true);
		$res = array();
		foreach ($data as $date => $value) {
			$res[$date] = new Picture($value);
		}
		return $res;
	}

	$pictures = loadPictures();

	if (isset($_GET["all"])) {
		$show_all = true;
	} else {
		$date = date("Y-m-d", time());
		if (isset($_GET["date"])) {
			$date = $_GET["date"];
		}

		$show_all = false;
		if (!array_key_exists($date, $pictures)) {
			if (isset($_GET["date"])) {
				$message = "<div class=\"error\">Picture for the selected date is not available. :(</div>";
			}
			$show_all = true;
		}

		$hd = false;
		if (isset($_POST["pass"])) {
			if ($_POST["pass"] == "nasa") {
				$hd = true;
			} else {
				$message = "<div class=\"error\">The secret code you entered is not valid.</div>";
			}
		}
	}
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

		<?php if (isset($message)) echo $message; ?>

		<a href="?all"><button>See catalog</button></a>

		<form>
			<input type="date" name="date">
			<input type="submit" value="See picture for a date">
		</form>

		<?php if (!$show_all) { ?>
		<form method="post">
			<label for="pass">Insert the secret code to see the picture in HD: </label>
			<input type="password" id="pass" name="pass">
			<input type="submit" value="See picture in HD">
		</form>
		<?php } ?>
		
		<div class="container">
		<?php
			if ($show_all) {
				foreach ($pictures as $picture) {
					echo $picture->getBriefHtml();
				}
			} else {
				echo $pictures[$date]->getHtml($hd);
			}
		?>
		</div>
	</div>
</body>
</html>
