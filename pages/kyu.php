<div class="text">
	<?php
	global $user_data;

		if (has_access($user_data['user_id'], 1)) {
			echo '<div class="in-album">(<a href="register_kyu.php">Dodaj novega člana v KYU register</a>)</div>';
		}
	?>
	<h1 align="center">KYU pasovi</h1><br><br>
	<?php
		$sql = mysql_query("SELECT * FROM `register_kyu`");

		if (mysql_num_rows($sql) == 0) {
			echo '<br><h1 align="center">V tem registru ni vpisanega nobenenga člana!</h1><br><br>';
		} else {
	?>

	<table class="dan">
		<tr>
			<th>Zap.št.</th>
			<th>Ime in Priimek</th>
			<th>Klub</th>
			<th>KYU</th>
			<th>Št. Licence</th>
			<th>Datum polaganja</th>
			<th>Kraj polaganja</th>
		</tr>
		<tr>
		<?php
			global $user_data;
			$query = mysql_query("SELECT * FROM `register_kyu`");
			$num_rows = mysql_num_rows($query);
			$num = 1;
			$num <= $num_rows;

			$sql = mysql_query("SELECT * FROM `register_kyu` ORDER BY `kyu`, `registered_name`");
					
			while ( $row = mysql_fetch_assoc($sql) ) {
				echo "<td>" . $num++ . ".</td><td>" . $row['registered_name'];
				if (has_access($user_data['user_id'], 1) === true) {
					echo '<br>';
					echo '<a href="delete_kyu.php?kyu_id=', $row['kyu_id'] ,'">Izbriši</a>'; 
					echo ' | '; 
					echo '<a href="uredi_kyu.php?kyu_id=', $row['kyu_id'] ,'">Uredi</a>';
				}  else {
					echo "";
				}
				echo "</td><td>" . $row['club'] . "</td><td>" . $row['kyu'] . "</td><td>" . $row['no_diploma'] . "</td><td>" . $row['registered_date'] . "</td><td>" . $row['registered_place'] . "</td></tr>";
			}
		?>
	</table><br>
	<p>* ??? = Podatek trenutno ni znan.</p>
	<?php
		}
	?>
</div>