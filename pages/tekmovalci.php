<div class="text">
	<?php
	global $user_data;

		if (has_access($user_data['user_id'], 1)) {
			echo '<div class="in-album">(<a href="register_clanov.php">Dodaj novega člana</a>)</div>';
		}
	?>
	<h1 align="center">Tekmovalci:</h1><br><br>
	<?php
		$sql = mysql_query("SELECT * FROM members WHERE status = 1");

		if (mysql_num_rows($sql) == 0) {
			echo '<br><h1 align="center">V tem registru Tekmovalcev ni vpisanega nobenenga člana!</h1><br><br>';
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
			$query = mysql_query("SELECT * FROM members WHERE status = 1");
			$num_rows = mysql_num_rows($query);
			$num = 1;
			$num <= $num_rows;
			$sql = mysql_query("SELECT * FROM members WHERE status = 1 ORDER BY first_name ASC");
					
			while ( $row = mysql_fetch_assoc($sql) ) {
				$date_birth = date_format(date_create($row['date_birth']), 'd.m.Y');

				echo "<td>" . $num++ . ".</td><td>" . $row['first_name'];
				echo ' ' . $row['last_name'];
				if (has_access($user_data['user_id'], 1) === true) {
					echo '<br>';
					echo '<a href="delete_member.php?member=', $row['member_id'] ,'">Izbriši</a>'; 
					echo ' | '; 
					echo '<a href="uredi_member.php?member_id=', $row['member_id'] ,'">Uredi</a>';
				} else {
					echo "";
				}
				echo "</td><td>" . $row['club'] . "</td><td>" . $row['pas'] . "</td><td>" . $date_birth . "</td></tr>";
			}
		?>
	</table><br>
	<?php
		}
	?>
</div>