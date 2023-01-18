<?php
	$r = rand(0,255);
	$g = rand(0,255);
	$b = rand(0,255);

	$today = date("Y-m-d", strtotime('today'));
	$tomorrow = date("Y-m-d", strtotime('tomorrow'));

	$img_no = rand(1, 10);
	$img_src = "images/fc".$img_no.".jpg";
?>
<html>
	<head>
		<title>Fortune Teller</title>
	</head>
	<body style="background-color:rgb(<?php echo "$r,$g,$b"; ?>)">
		<center>
		<h1>Welcome to the Fortune teller website.</h1>
		<img src='images/fortune_teller.jpg'>
		<h2>We will tell your fortune by providing you with a fortune cookie.</h2>
		<h3>Todays date is: <?php echo $today; ?>, and we are telling the future for tomorrow: <?php echo $tomorrow; ?></h3>
		<p>This is your fortune for today:</p>
		<img src="<?php echo $img_src; ?>" width="400" height="400">
	</body>
</html>
