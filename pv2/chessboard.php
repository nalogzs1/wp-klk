<!DOCTYPE html>  
<html>   
<head>   
	<title>Sahovska tabla</title>  
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
    <h3>Šahovska tabla</h3>
    <table border="1">
        <?php
			for($row = 1; $row <= 8; $row++) {
				echo "<tr>\n";
				for($col = 1; $col <= 8; $col++) {
					if(($col + $row) % 2 == 0) {
						$color = "black";
					} else {
						$color = "white";
					}
					echo "<td style=\"width:50px;height:50px;background-color:$color;\"></td>\n";
				}
				echo "</tr>\n";
			}
        ?> 
    </table>  
</body>  
</html>  