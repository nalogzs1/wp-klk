<?php
	define("MAX_INDEX", 10);
	define("PICS_PER_PAGE", 3);

	// Racunamo broj stranica
	$pages_count = ceil((MAX_INDEX + 1) / PICS_PER_PAGE);
	
	// Stavljamo da je trenutni page po defoltu 1.
	$page = 1;
	
	// Proveravamo da li u query stringu postoji definisan page.
	// Ukoliko postoji, page se uzima iz query stringa.
	if (isset($_GET["page"])) {
		$page = (int) $_GET["page"];
		// Ukoliko page nije u odgovarajucem opsegu, postaviti ga na defolt, tj. na 1.
		if (!($page >= 1 && $page <= $pages_count)) {
			$page = 1;
		}
	}
	
	// Indeks prve slike koju treba prikazati
	$img_from = ($page-1) * PICS_PER_PAGE;
	$img_to = min($img_from + PICS_PER_PAGE, MAX_INDEX+1);

	// Provera filter stringa
	if (isset($_GET["filter"])) {
		$filter = $_GET["filter"];
		$filter_arr = explode('-', $filter);
		if (count($filter_arr) == 2) {
			$from = (int) $filter_arr[0];
			$to = (int) $filter_arr[1];
			if ($from < $to && $from >= 0 && $from < MAX_INDEX && $to > 0 && $to <= MAX_INDEX) {
				$img_from = $from;
				$img_to = $to + 1;
			}
		}
	}
?>

<html>
	<head>
		<title>Galerija</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<header>
			<h1>Galerija</h1>
		</header>
		<form action="" method="get">
			U polje ispod možete uneti tekst formata x-y. Primer: ukoliko unesete 5-9, na stranici će se prikazati slike rednih brojeva iz opsega [5,9]. <br/>
			<input type="text" name="filter"/>
			<input type="text" name="filter2"/>
			<input type="submit" value="Primeni filter"/>
		</form>
		<?php
			// Ispis svih slika na tekucoj strani.
			for ($i = $img_from; $i < $img_to; $i++) {
				echo "<img src='images/$i.jpg'/>";
			}
		?>
		<div class="link-group">
			<?php
				// Ispis linkova na sve stranice.
				for ($i = 1; $i <= $pages_count; $i++) {
					echo "<a href='?page=$i'>$i</a> ";
				}
			?>
		</div>
	</body>
</html>