<div class="text">
	<?php
	global $user_data;

		if (has_access($user_data['user_id'], 1)) {
			echo '<div class="in-album">(<a href="register_dan.php">Dodaj novega člana v DAN register</a>)</div>';
		}
	?>
	<h1 align="center">DAN pasovi</h1><br><br>
	<?php
		$sql = mysql_query("SELECT * FROM `register_dan`");

		if (mysql_num_rows($sql) == 0) {
			echo '<br><h1 align="center">V tem registru ni vpisanega nobenenga člana!</h1><br><br>';
		} else {
	?>

	<table class="dan">
		<tr>
			<th>Zap.št.</th>
			<th>Ime in Priimek</th>
			<th>Klub</th>
			<th>DAN</th>
			<th>Št. Licence</th>
			<th>Datum polaganja</th>
			<th>Kraj polaganja</th>
		</tr>
		<tr style="font-weight:bold;">
			<td>1.</td>
			<td>Milenko Railić<br>(Glavni trener)</td>
			<td>Društvo za borilne veščine Piran</td>
			<td>6. DAN</td>
			<td>SLO-722-11</td>
			<td>19.06.2011</td>
			<td>Vrhnika</td>
		</tr>
		<tr style="font-weight:bold;">
			<td>2.</td>
			<td>Mladen Railić<br>(Trener)</td>
			<td>Društvo za borilne veščine Piran</td>
			<td>3. DAN</td>
			<td>12/12/2013</td>
			<td>27.12.2013</td>
			<td>Portorož</td>
		</tr>
		<tr style="font-weight:bold;">
			<td>3.</td>
			<td>Gabrijel Franca<br>(Trener)</td>
			<td>Društvo za borilne veščine Piran</td>
			<td>3. DAN</td>
			<td>11/12/2013</td>
			<td>27.12.2013</td>
			<td>Portorož</td>
		</tr>
		<tr>
		<?php
			global $user_data;
			$query = mysql_query("SELECT * FROM `register_dan`");
			$num_rows = mysql_num_rows($query);
			$num = 4;
			$num <= $num_rows;

			$sql = mysql_query("SELECT * FROM `register_dan` ORDER BY `dan` DESC, `registered_name` ASC");
					
			while ( $row = mysql_fetch_assoc($sql) ) {
				echo "<td>" . $num++ . ".</td><td>" . $row['registered_name'];
				if (has_access($user_data['user_id'], 1) === true) {
					echo '<br>';
					echo '<a href="delete_dan.php?dan_id=', $row['dan_id'] ,'">Izbriši</a>'; 
					echo ' | '; 
					echo '<a href="uredi_dan.php?dan_id=', $row['dan_id'] ,'">Uredi</a>';
				}  
				echo "</td><td>" . $row['club'] . "</td><td>" . $row['dan'] . "</td><td>" . $row['no_diploma'] . "</td><td>" . $row['registered_date'] . "</td><td>" . $row['registered_place'] . "</td></tr>";
			}
		?>
	</table><br>
	<p>* ??? = Podatek trenutno ni znan.</p>
	<?php
		}
	?>
</div>