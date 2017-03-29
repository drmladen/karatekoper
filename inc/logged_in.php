<div class="sticky-mobile1">
	<div id="show_signin">
		<button><?php echo $user_data['first_name']; ?></button>
	</div>
	<form action="login.php" method="POST" id="mobile_down">
		<ul class="logged-down">
			<li><a href="<?php echo $user_data['username']; ?>">Profil</a></li><br>
			<li><a href="nastavitve.php">Nastavitve</a></li><br>
			<li><a href="newpassword.php">Spremeni Geslo</a></li><br>
			<?php 
				if (has_access($session_user_id, 1) === true) {
					echo '<li><a href="administrator.php">Administratorska stran</a></li><br>';
				} else if (has_access($session_user_id, 2) === true) {
					echo '<li><a href="administrator.php">Moderatorska stran</a></li><br>';
				}
			?>
			<li><a href="logout.php">Odjava</a></li>
		</ul>
		<?php
			$user_count = user_count();	
		?>
		<p style="margin-left: 20px; margin-bottom: 5px;">Trenutno imamo <?php echo $user_count; ?> registriran<?php 
		if ($user_count == 0) {
			echo 'ih';
		} else if ($user_count == 1) {
			echo 'ega';
		} else if ($user_count == 2) {
			echo 'a';
		} else if ($user_count == 3 && 4) {
			echo 'e';
		} else if ($user_count != 1 && 2 && 3 && 4) {
			echo 'ih';
		}
	?> uporabnik<?php
		if ($user_count == 0) {
			echo 'ov';
		} else if ($user_count == 1 && 2) {
			echo 'a';
		} else if ($user_count == 3 && 4) {
			echo 'e';
		} else if ($user_count != 1 && 2 && 3 && 4) {
			echo 'ov';
		}
	?>.</p>
	</form>
</div>