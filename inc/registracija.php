<?php
	if (empty($_POST) === false) {
		$required_fields = array('first_name', 'last_name', 'birth_date', 'username', 'email', 'password', 'password_again', 'strinjamse');
		foreach ($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = '<h2 align="center" style="color:red">* Izpolniti morate vsa polja!</h2>';
			break 1;
			}
		}
		if (empty($errors) === true) {
			if (user_exists($_POST['username']) === true) {
				$errors[] = '<h3 align="center" style="color:red">* Oprostite, uporabniško ime \'' . htmlentities($_POST['username']) . '\' je že v uporabi.</h3>'; 
			}
			if (preg_match('/\\s/', $_POST['username']) == true) {
				$errors[] = '<h3 align="center" style="color:red">* Uporabniško ime ne sme vsebovati presledkov.</h3>';
			}
			if ($_POST['password'] !== $_POST['password_again']) {
				$errors[] = '<h3 align="center" style="color:red">* Gesli se ne ujemata.</h3>';	
			}
			if (preg_match('/\\s/', $_POST['first_name']) == true) {
				$errors[] = '<h3 align="center" style="color:red">* Vaše ime ne sme vsebovati presledkov.</h3>';
			}
			if (preg_match('/\\s/', $_POST['last_name']) == true) {
				$errors[] = '<h3 align="center" style="color:red">* Vaš priimek ne sme vsebovati presledkov.</h3>';
			}
			if (preg_match('/\\s/', $_POST['password']) == true) {
				$errors[] = '<h3 align="center" style="color:red">* Vaše geslo ne sme vsebovati presledkov.</h3>';
			}
			if (strlen($_POST['username']) < 6) {
				$errors[] = '<h3 align="center" style="color:red">* Vaše uporabniško ime mora vsebovati vsaj 6 znakov.</h3>';
			}
			if (strlen($_POST['username']) > 30) {
				$errors[] = '<h3 align="center" style="color:red">* Vaše uporabniško ime ne sme vsebovati več kot 30 znakov.</h3>';
			}
			if (strlen($_POST['password']) < 8) {
				$errors[] = '<h3 align="center" style="color:red">* Vaše geslo mora vsebovati vsaj 8 znakov.</h3>';
			}
			if (strlen($_POST['password']) > 30) {
				$errors[] = '<h3 align="center" style="color:red">* Vaše geslo ne sme vsebovati več kot 30 znakov.</h3>';
			}
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
				$errors[] = '<h3 align="center" style="color:red">* Potreben je veljaven e-naslov.</h3>';
			}
			if (email_exists($_POST['email']) === true) {
				$errors[] = '<h3 align="center" style="color:red">* Oprostite, e-naslov \'' . htmlentities($_POST['email']) . '\' je že v uporabi.</h3>';
			}
			if (empty($_POST['strinjamse'])) {
				$errors[] = '<h3 align="center" style="color:red">* Morate se strinjati s pogoji, če se želite registrirati!</h3>';
			}
			if (empty($_POST['birth_date'])) {
				$errors[] = '<h3 align="center" style="color:red">* Morate izpolniti polje \'Rojstni datum\' se strinjati s pogoji, če se želite registrirati!</h3>';
			}
		}
	}
?>
<div class="text">
<h2>Registracija:</h2><br>
<?php
		if (empty($_POST) === false && empty($errors) === true) {
			$register_data = array(
				'username' 		=> $_POST['username'],
				'password' 		=> $_POST['password'],
				'first_name' 	=> $_POST['first_name'],
				'last_name' 	=> $_POST['last_name'],
				'birth_date'	=> $_POST['birth_date'],
				'email' 		=> $_POST['email'],
				//'email_code'	=> md5($_POST['username'] + microtime()),
				'sendmail'	=> $_POST['sendmail']
			);
			register_user($register_data);
			header('Location: index.php?p=success');
		exit();
		} else if (empty($errors) === false) {
			echo output_errors($errors);
		}
?>
	<form action="" method="post">
		<fieldset>
			<legend><strong>Vaši podatki:</strong></legend>
			<ul>
				<li>Ime: <div class="inputfield"><input type="text" name="first_name"></div></li>
				<li>Priimek: <div class="inputfield"><input type="text" name="last_name"></div></li>
				<li>Rojstni datum: <div class="inputfield"><input type="date" name="birth_date"></div></li>
				<li>Uporabniško ime: <div class="inputfield"><input type="text" name="username"></div></li>
				<li>E-pošta: <div class="inputfield"><input type="text" name="email"></div></li>
				<li>Geslo: <div class="inputfield"><input type="password" name="password"></div></li>
				<li>Ponovi geslo: <div class="inputfield"><input type="password" name="password_again"></div></li>
				<li class="agreement"><input class="block" type="checkbox" name="strinjamse" value="strinjamse" checked> Strinjam se s <a href="">splošnimi pogoji.</a></li>
				<li class="agreement"><input class="block" type="checkbox" name="sendmail" value="sendmail" checked> Hočem prejemati novice kluba</li>
			</ul>
			<button type="submit" class="accept"><a href="">Prekliči</a></button>
			<button class="accept">Potrdi</button>		
		</fieldset><br><br>
	</from>
</div>