<div class="text">
	<h1 align="center">Člani kluba:</h1><br><br>
	<?php
		$sql = mysql_query("SELECT * FROM register_kyu");

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
			<th>Datum rojstva</th>
		</tr>
		<tr>
		<?php
			global $user_data;
			$query = mysql_query("SELECT * FROM register_kyu");
			$num_rows = mysql_num_rows($query);
			$num = 1;
			$num <= $num_rows;

			$sql = mysql_query("SELECT * FROM register_kyu ORDER BY club DESC, registered_name");
					
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
				echo "</td><td>" . $row['club'] . "</td><td>" . $row['kyu'] . "</td><td>" . $row['registered_date'] . "</td></tr>";
			}
		?>
	</table><br>
	<p>* ??? = Podatek trenutno ni znan.</p>
	<?php
		}
	?>
</div>