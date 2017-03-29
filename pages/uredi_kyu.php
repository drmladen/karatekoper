<?php
ob_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/core/init.php';
admin_protect();
$ptitle = "Karate klub Koper";
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/head.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/menu.php';

	if (empty($_POST) === false) {
		$required_fields = array('registered_name', 'club', 'kyu', 'no_diploma', 'registered_date', 'registered_place');
		foreach ($_POST as $key=>$value) {
		if (empty($value) && in_array($key, $required_fields) === true) {
			$errors[] = '<h2 align="center" style="color:red">* Izpolniti morate vsa polja!</h2>';
			break 1;
			}
		}
		if (empty($errors) === true) {
			global $user_data;
			if (has_access($user_data['user_id'], 1) === false) {
				$errors[] = '<h3 align="center" style="color:red;">* Oprostite morate imeti administratorske pravice, da spremenite register pasov!</h3>';
			}
		}
		$sql = mysql_query("SELECT * FROM `register_kyu`");
		$row = mysql_fetch_assoc($sql);
		if ($row['registered_name'] == $_POST['registered_name']) {
			$errors[] = '<h3 align="center" style="color:red;">* Ime, ki ste ga vnesli že obstaja. Če želite posodobiti njegove podatke pritisnite <a href="">tukaj</a>!</h3><br>';
		}
	}
?>
<div class="body">
	<div class="text">
	<h1 class="hover">Uredite člana v KYU register (<a href="administrator.php">Administratorska stran</a>):</h1><br><br><br>
	<?php
		if (!isset($_POST['submit'])) {
			$sql = mysql_query("SELECT * FROM `register_kyu` WHERE `kyu_id` = $_GET[kyu_id]") or die(mysql_error());
			
			$row = mysql_fetch_array($sql);
		}
	?>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
		<fieldset>
			<legend><strong>Podatki zadnjega polaganja člana:</strong></legend>
			<ul>
				<li>Ime in Priimek: <div class="inputfield"><input type="text" name="registered_name"></div></li>
				<li>Klub: <div class="inputfield">
				<select name="club" id="club">
					<option></option>
					<option value="Društvo za borilne veščine Piran">Društvo za borilne veščine Piran</option>
					<option value="Karate klub Koper">Karate klub Koper</option>
				</select></div></li>
				<li>Kyu: <div class="inputfield">
					<select name="kyu" id="kyu">
						<option></option>
						<option value="1. KYU">1. KYU</option>
						<option value="2. KYU">2. KYU</option>
						<option value="3. KYU">3. KYU</option>
						<option value="4. KYU">4. KYU</option>
						<option value="5. KYU">5. KYU</option>
						<option value="6. KYU">6. KYU</option>
						<option value="7. KYU">7. KYU</option>
						<option value="8. KYU">8. KYU</option>
						<option value="9. KYU">9. KYU</option>
                    </select>
				</div></li>
				<li>Št. Diplome: <div class="inputfield"><input type="text" name="no_diploma"></div></li>
				<li>Datum zadnjega polaganja: <div class="inputfield"><input type="text" name="registered_date"></div></li>
				<li>Kraj zadnjega polaganja: <div class="inputfield"><input type="text" name="registered_place"></div></li>				
				</ul>
			<input type="hidden" name="kyu_id" value="<?php echo $_GET['kyu_id'] ?>">
			<input type="hidden" name="action" value="Dodaj v register">
			<button class="accept">Dodaj v register</button>		
		</fieldset><br><br>
	</form>
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