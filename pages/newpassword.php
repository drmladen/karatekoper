<?php
ob_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/core/init.php';
protect_page();
$ptitle = "Karate klub Koper";
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/head.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/menu.php';

if (empty($_POST) === false) {
	$required_fields = array('current_password', 'password', 'password_again');
	foreach ($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = '<h2 align="center" style="color:red;">* Vsa polja morajo biti izpolnjena.</h2>';
			break 1;
		}
	}
	if (md5($_POST['current_password']) === $user_data['password']) {
		if (trim($_POST['password']) !== trim($_POST['password_again'])) {
			$errors[] = '<h2 align="center" style="color:red;">* "Novo geslo" in "Ponovljeno geslo" se ne ujemata.</h2>';
		} else if (strlen($_POST['password']) < 8) {
			$errors[] = '<h2 align="center" style="color:red;">* Vaše geslo mora vsebovati vsaj 8 znakov.</h2>';	
		} else if (strlen($_POST['password']) > 30) {
			$errors[] = '<h2 align="center" style="color:red;">* Vaše geslo ne sme vsebovati več kot 30 znakov.</h2>';	
		}
	} else {
		$errors[] = '<h2 align="center" style="color:red;">* Tvoje trenutno geslo je nepravilno.</h2><br>';	
	}
}
?>
<div class="body">
	<div class="text">
		<h1 align="center">Tukaj lahko spremenite geslo:</h1><br><br>
		<?php 
			if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
				echo 'Your password has been changed.';
			} else {
				
				if (isset($_GET['force']) === true && empty($_GET['force']) === true) {
				?>
					<p>You must change your password now that you' ve requested.</p>
			    <?php
				}
				
				if (empty($_POST) === false && empty($errors) === true) {
					change_password($session_user_id, $_POST['password']);
					header('Location: newpassword.php?success');
				} else if (empty($errors) === false) {
					echo output_errors($errors);
				}
		?>
		<form action="" method="post" style=" font-weight: bold;" class="footer-signin">
			<ul class="none">
				<li>
		        	Trenutno geslo:<br> 
		            <input type="password" name="current_password">
		        </li>
				<li>
		        	Novo geslo:<br> 
		            <input type="password" name="password">
		        </li>
		        <li>
		        	Ponovi novo geslo:<br> 
		            <input type="password" name="password_again">
		        </li>
		        <li>
		        	<input type="submit" value="Spremeni geslo">
		        </li>
			</ul>
		</form><br><br>
	</div>
</div>
<?php
}
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/ontop.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/footer.php';
ob_flush();
?>