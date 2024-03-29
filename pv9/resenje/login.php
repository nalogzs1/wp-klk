<?php
	require_once("db_utils.php");

	$d = new Database();
	$errors = [];
	$messages = [];

	session_start();

	if (isset($_GET["logout"])){
		session_destroy();
	} elseif (isset($_SESSION["user"])) {
		header( "Location: profile.php" );
	}

	if (isset($_GET["login-fail"])) {
		$messages[] = "Pogrešan username ili šifra";
	}

	if (isset($_GET["forget-me"])) {
		setcookie("username", "", time()-1000);
		header("Location: login.php");
	}

	function outputError($errorCode) {
		global $errors;
		if (isset($errors[$errorCode])) {
			echo '<div class="error">' . $errors[$errorCode] . '</div>';
		}
	}
	
	$name = $username = $profession = $address = $gender = $password1 = $password2 = $birthday =  "";
	
	if (isset($_POST["registerButton"])) {
		// Setovanje promenljivih iz registracione forme
		if ($_POST["name"]) {
			$name = htmlspecialchars($_POST["name"]);
		}	
		if ($_POST["username"]) {
			$username = htmlspecialchars($_POST["username"]);
		}
		if ($_POST["profession"]) {
			$profession = htmlspecialchars($_POST["profession"]);
		}
		if ($_POST["address"]) {
			$address = htmlspecialchars($_POST["address"]);
		}
		if ($_POST["password1"]) {
			$password1 = $_POST["password1"];
		}	
		if ($_POST["password2"]) {
			$password2 = $_POST["password2"];
		}
		if ($_POST["birthday"]) {
			$birthday = htmlspecialchars($_POST["birthday"]);
		}
		if (isset($_POST["pol"])) {
			$gender = htmlspecialchars($_POST["pol"]);
		}

		// Validacija podataka iz registracione forme
		if (!$name) {
			$errors["name"] = "Unesite ime i prezime";
		}		
		if (!$username) {
			$errors["username"] = "Unesite korisničko ime";
		}		
		if (!$profession) {
			$errors["profession"] = "Unesite profesiju";
		}		
		if (!$address) {
			$errors["address"] = "Unesite adresu";
		}		
		if (!$password1) {
			$errors["password1"] = "Unesite lozinku";
		}
		if ($password1 != $password2){
			$errors["poklapanjeLozinki"] = "Lozinke su različite";
		}		
		if (!$birthday) {
			$errors["birthday"] = "Unesite datum rođenja";
		}

		if (empty($errors)) {
			$success = $d->insertUser($username, $password1, $name, $profession, $address, $birthday, $gender);
			$messages[] = $success ? "Uspešno ste se registrovali" : "Registracija nije uspela";
		}
	}
?>

<html>
	<head>
		<title>Socijalna mreža</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body>	
		<h1>Dobrodošli!</h1>
		<div id="sadrzaj">
			<?php
				if (!empty($messages)) {
					echo "<div class=\"kontejner poruke svetlo\">";
					foreach ($messages as $message) {
						echo "<div>$message</div>";
					}
					echo "</div><br>";
				}
			?>

			<div class="kontejner login svetlo">
				<h2>Uloguj se</h2>
				<form method="post" action="profile.php">
					<label for="username">Korisničko ime:</label> 
					<input type="text" name="username" value="<?php echo isset($_COOKIE["username"]) ? $_COOKIE["username"] : "";?>"><br>

					<label for="password">Lozinka:</label>
					<input	type="password" name="password"><br>
					
					<input type="checkbox" name="remember-me" checked> Zapamti moj username<br> 
					<a href="?forget-me">Forget me</a>

					<input type="submit" name="loginButton" value="Uloguj se">
				</form>
			</div>
			
			<div class="kontejner registracija svetlo">
				<h2>Registruj se</h2>
				<p>* Obavezno polje.</p>
				<form method="post" action="">
					<label for="name" class="obavezno-polje">Ime i prezime:</label>
					<?php outputError("name");?>
					<input type="text" name="name" value="<?php echo $name;?>"><br>
	  				
					<label for="username" class="obavezno-polje">Korisničko ime:</label>
					<?php outputError("username");?>
					<input type="text" name="username" value="<?php echo $username;?>"><br>
	  				
					<label for="profession" class="obavezno-polje">Profesija:</label>
					<?php outputError("profession");?>
					<input type="text" name="profession" value="<?php echo $profession;?>"><br>
	  				
					<label for="address" class="obavezno-polje">Adresa:</label>
					<?php outputError("address");?>
					<input type="text" name="address" value="<?php echo $address;?>"><br>
	  				
					<label for="password1" class="obavezno-polje">Lozinka:</label>
					<?php outputError("password1");?>
					<input type="password" name="password1" value="<?php echo $password1;?>"><br>
	  				
					<label for="password2" class="obavezno-polje">Ponovi lozinku:</label>
					<?php outputError("password2");?>
					<?php outputError("poklapanjeLozinki");?>
					<input type="password" name="password2" value="<?php echo $password2;?>"><br>
	  				
					<label for="date" class="obavezno-polje">Datum rođenja:</label>
					<?php outputError("birthday");?>
					<input type="date" name="birthday" value="<?php echo $birthday;?>"><br>
	  				
					<label for="pol">Pol:</label> <br>
					<?php outputError("gender");?>
					<input type="radio" name="pol" value="m" <?php if ($gender == "m") echo 'checked'; ?>> M 
					<input type="radio" name="pol" value="z" <?php if ($gender == "z") echo 'checked'; ?>> Ž <br> 
					
					<input type="checkbox" name="novosti" checked> Želim da dobijam novosti<br> 
					<input type="submit" name="registerButton" value="Registruj se">
				</form>
			</div>
		</div>
	</body>
</html>