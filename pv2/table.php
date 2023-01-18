<!DOCTYPE html>
<html>
<head>
	<title>Tablica mozenja</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<h3>Tablica množenja</h3>
	<?php  
		echo "<table border =\"1\">";
		for ($row = 1; $row <= 10; $row++) {
			echo "<tr>\n";
			for ($col = 1; $col <= 10; $col++) {
				$p = $col * $row;
				echo "<td>$p</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>";
	?>        
</body>
</html>  