<?php
ob_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/core/init.php';
protect_page();
$ptitle = "Karate klub Koper";
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/head.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/menu.php';


if (empty($_POST) === false) {
	$required_fields = array('username', 'first_name', 'last_name', 'email', 'birth_date', 'sendmail');
	foreach ($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = '<h2 style="color:red;">* Vsa polja morajo biti izpoljnjena.</h2>';
			break 1;
		}
	}
	
	if (empty($errors) === true) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = '<h2 style="color:red;">* Potrebno je vnesti veljaven e-poštni naslov.</h2>';
		} else if (email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
			$errors[] = '<h2 style="color:red;">* Oprostite, e-poštni naslov \'' . $_POST['email'] . '\' je že v uporabi.</h2>';
		}
		if (user_exists($_POST['username']) === true && $user_data['username'] !== $_POST['username']) {
				$errors[] = '<h2 style="color:red">* Oprostite, uporabniško ime \'' . htmlentities($_POST['username']) . '\' je že v uporabi.</h2>'; 
		}
	}
}
?>
<div class="text">
	<h1>Nastavitve profila:</h1><br><br>
	<h2>Če želite spremeniti geslo kliknite <a href="newpassword.php">tukaj!</a></h2><br><br>
	<?php 
		if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
			echo '<h2>Vaši podatki so bili posodobljeni!</h2>';
		} else {
			if (empty($_POST) === false && empty($errors) === true) {
				
				$update_data = array(
					'username' 		=> $_POST['username'],
					'first_name' 	=> $_POST['first_name'],
					'last_name' 	=> $_POST['last_name'],
					'email' 		=> $_POST['email'],
					//'allow_email'	=> ($_POST['allow_email'] == 'on') ? 1 : 0,
					'birth_date' 	=> $_POST['birth_date'],
					'sendmail' 		=> $_POST['sendmail']
				);

				print_r($update_data);
				
				//update_user($session_user_id, $update_data);
				//header('Location: index.php?success');
				exit();
				
			} else if (empty($errors) === false) {
				echo output_errors($errors);
			}
		
	?>
	<form action="" method="POST" class="footer-signin">
		<ul>
			<li>Uporabniško ime:</li>
			<li><input type="text" name="username" value="<?php echo $user_data['username'] ?>"></li>
			<li>Ime:</li>
			<li><input type="text" name="first_name" value="<?php echo $user_data['first_name'] ?>"></li>
			<li>Priimek:</li>
			<li><input type="text" name="last_name" value="<?php echo $user_data['last_name'] ?>"></li>
			<li>E-pošta:</li>
			<li><input type="text" name="email" value="<?php echo $user_data['email'] ?>"></li>
			<li>Rojstni datum:</li>
			<li><input type="date" name="birth_date" value="<?php echo $user_data['birth_date'] ?>"></li>
			<li><input style="width: 2.5%;" class="block" type="checkbox" name="sendmail" value="sendmail" checked> Hočem prejemati novice kluba</li>
			<li><input type="submit" value="S P R E M E N I"></li>
		</ul>
	</form><br><br>
	<?php 
	}
	?>
	</div>
</div>
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/ontop.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/footer.php';
ob_flush();
?>