<form action="login.php" method="POST" class="sticky-signin">
	<ul>
		<li><input type="username" name="username" placeholder="Uporbniško ime" "></li>
		<li><input type="password" name="password" placeholder="Geslo"></li>
		<li><input type="submit" class="button-sign" name="Prijava" value="Prijava"></li>
		<li><a href="registracija.php" class="button-sign">Registracija</a></li>
	</ul>
	<p style="color: #fff; margin-left: 5px; margin-top: 2px; font-size: 80%">Ste pozabili Vaše <a style="color: #000; font-size: 100%; font-weight: bold;" href="pozabljeno.php?mode=username">Uporabniško ime</a> ali <a style="color: #000; font-size: 100%; font-weight: bold;" href="pozabljeno.php?mode=password">Geslo</a>!</p>
</form>
<div class="sticky-mobile">
	<div id="show_signin">
		<button>Prijava</button>
	</div>
	<form action="login.php" method="POST" id="mobile_down">
		<ul>
			<li><input type="username" name="username" placeholder="Uporbniško ime"></li>
			<li><input type="password" name="password" placeholder="Geslo"></li>
			<li><input type="submit" class="button-signin" name="Prijava" value="Prijava"></li>
			<li><a href="registracija.php" class="button-signin">Registracija</a><br><br><br></li>
		</ul>
		<p style="color: #fff; margin-left: 20px; margin-bottom: 10px; font-size: 120%">Ste pozabili Vaše <a style="color: #000; font-size: 100%; font-weight: bold;" href="pozabljeno.php?mode=username">Uporabniško ime</a> ali <a style="color: #000; font-size: 100%; font-weight: bold;" href="pozabljeno.php?mode=password">Geslo</a>!</p>
	</form>
</div>