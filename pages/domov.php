	<div class="info">
		<table class="home-wide">
			<tr>
				<td class="olimpic-home"><img class="olimpic-up" src="/test/Nova_stran/images/olimpic.png"><img class="olimpic-para" src="/test/Nova_stran/images/paraol.png"></td>
				<td class="olimpic-text">
					<h1>KARATE JE KONČNO POSTAL OLIMPIJSKI ŠPORT</h1><br>
					<p><strong>V dneh pred odprtjem olimpijskih iger v Riu je potekalo zasedanje skupščine Mednarodnega olimpijskega komiteja (MOK), kjer so soglasno potrdili, da je KARATE postal novi olimpijski šport. KARATE so vključili v program olimpijskih iger v Tokiu leta 2020. S tem so se uresničile dolgoletne želje in sanje tako našega kluba kot tudi številnih karateistov po vsem svetu.</strong><br><br>
					Med izborom novih športov je KARATE-ju šlo v prid dejstvo, da je popularen na Japonskem, saj bo le-ta gostiteljica iger. Predvsem pa so gledali popularnost športa med mladino modernega sveta, ki bi na ta način postala bolj povezana z olimpijskim gibanjem. Če poznamo dejstvo, da je KARATE nedvomno eden izmed treh najbolj razširjenih borilnih športov na svetu, je potreboval zelo veliko časa, da je bil sprejet v olimpijsko družino. Veseli nas, da je tudi naš klub član te družine, kjer bo poskušal s sistematičnim delom in vztrajnostjo poslati vsaj enega člana kluba na ene izmed olimpijskih iger v prihodnosti, kjer verjamemo, da se bo KARATE obdržal še zelo dolgo.</p></td>
			</tr>
		</table>
		<table class="info-club">
			<tr>
				<td width="30%"><img src="/test/Nova_stran/images/domov1.png"></td>
  				<td width="35%">
  					<h3>Karate Klub Koper<br>Club di Karate Capodistria</h3>
					<p>Prade - cesta X/008<br>
					6000 Koper<br>
					Slovenija<br>
					+386 40 643 460 (Mladen)<br>
					karatekoper@gmail.com</p>
  				</td>
  				<td><h2>Kje treniramo:</h2>
  					<p>V mali telovadnici na O.Š. Dušana Bordona</p>
  					<h2>Kdaj treniramo:</h2>
  					<p>Sreda: 18h00 do 19h30<br>
  					Petek: 18h00 do 19h30</p>
  				</td>
  			</tr>
		</table>
	</div>
	<div class="active-news">
		<?php 
			$sql = mysql_query("SELECT * FROM `news`");

			if (mysql_num_rows($sql) == 0) {
				echo '<table class="news"><tr><td class="news-img"><img src="/test/Nova_stran/images/domov1.png"></td><td class="news-title"><h1>Na naši internetni strani trenutno ni aktualnih novic</h1><br><p>Na strani ni aktualnih novic!<br>Na strani ni aktualnih novic!<br>Na strani ni aktualnih novic!<br></p><br></td></tr></table>';
			} else {
				$sql = mysql_query("SELECT * FROM `news` ORDER BY `time` DESC LIMIT 0, 1");

				while ($row = mysql_fetch_assoc($sql)) {
					$news_limited = $row['news'];
					$news_limited = substr($news_limited,0,700).'...';
					$news_id = $row['news_id'];
					$news_time = date_format(date_create($row['time']), 'd.m.Y, H:i');

					if (class_exists('Comments')) {
						$num_comments = Comments::getNumComments($news_id, 0);
						$news_user = Users::getUser($row['user_id']);
					}

					echo '<table class="news"><tr><td class="news-img"><a href="index.php?p=aktualno">';
					if (empty($row['news_picture']) === true) {
						echo '<img src="novice_slike/domov1.png" />';
					} else {
						echo '<img src="novice_slike/' . $row['news_picture'] . '" />';
					}
					echo '</a></td><td class="news-title"><h1><a href="index.php?p=aktualno">' . $row['news_title'] . '</a></h1>';
					echo '<div class="home-info">Datum novice: ' . $news_time . '<br>Avtor novice: ' . $news_user-> first_name . ' ' . $news_user-> last_name . ' (Komentarjev: ' . $num_comments . ')</div>';
					echo '<p><a href="index.php?p=aktualno">' . $news_limited . '</a></p><br><p class="button"><a href="index.php?p=aktualno">Preberi Več...</a></p></td></tr></table>';
				}
			}
		?>
	</div>
	<div class="body-mobile">
		<img src="/test/Nova_stran/images/olimpic.png">
		<img class="middle-img" src="/test/Nova_stran/images/domov1.png">
		<img src="/test/Nova_stran/images/paraol.png">
		<h1 align="left">KARATE JE KONČNO POSTAL OLIMPIJSKI ŠPORT</h1><br>
		<p><strong>V dneh pred odprtjem olimpijskih iger v Riu je potekalo zasedanje skupščine Mednarodnega olimpijskega komiteja (MOK), kjer so soglasno potrdili, da je KARATE postal novi olimpijski šport. KARATE so vključili v program olimpijskih iger v Tokiu leta 2020. S tem so se uresničile dolgoletne želje in sanje tako našega kluba kot tudi številnih karateistov po vsem svetu.</strong><br><br>
		Med izborom novih športov je KARATE-ju šlo v prid dejstvo, da je popularen na Japonskem, saj bo le-ta gostiteljica iger. Predvsem pa so gledali popularnost športa med mladino modernega sveta, ki bi na ta način postala bolj povezana z olimpijskim gibanjem. Če poznamo dejstvo, da je KARATE nedvomno eden izmed treh najbolj razširjenih borilnih športov na svetu, je potreboval zelo veliko časa, da je bil sprejet v olimpijsko družino. Veseli nas, da je tudi naš klub član te družine, kjer bo poskušal s sistematičnim delom in vztrajnostjo poslati vsaj enega člana kluba na ene izmed olimpijskih iger v prihodnosti, kjer verjamemo, da se bo KARATE obdržal še zelo dolgo.</p><br>
		<div class="contact-info">
  			<h3><br>
  			Karate Klub Koper<br>
  			Club di Karate Capodistria
  			</h3>
			<p>
			Prade - cesta X/008<br>
			6000 Koper<br>
			Slovenija<br>
			+386 40 643 460 (Mladen)<br>
			karatekoper@gmail.com
			</p>
  			<h2>
  			Kje treniramo:
  			</h2>
  			<p>
  			V mali telovadnici na O.Š. Dušana Bordona
  			</p>
  			<h2>
  			Kdaj treniramo:
  			</h2>
  			<p>
  			Sreda: 18h00 do 19h30<br>
  			Petek: 18h00 do 19h30
  			</p>
		</div><br>
	</div>
	<div class="active-mobile">
		<?php 
			$sql = mysql_query("SELECT * FROM `news`");

			if (mysql_num_rows($sql) == 0) {
				echo '<h1 style="border-bottom:3px solid #999;padding:0 10px;">Na naši internetni strani trenutno ni aktualnih novic</h1><img style="width:90%;margin:10px 5%;" src="/test/Nova_stran/images/domov1.png"><p style="padding:10px;">Na strani ni aktualnih novic!<br>Na strani ni aktualnih novic!<br>Na strani ni aktualnih novic!<br></p>';
			} else {
				$sql = mysql_query("SELECT * FROM `news` ORDER BY `time` DESC LIMIT 0, 1");

				while ($row = mysql_fetch_assoc($sql)) {
					$news_limited = $row['news'];
					$news_limited = substr($news_limited,0,400).'...';


					echo '<a style="color:#333;" href="index.php?p=aktualno"><h1 style="border-bottom:3px solid #999;padding:0 10px;">Na naši internetni strani trenutno ni aktualnih novic</h1></a>';
					echo '<a href="index.php?p=aktualno"><img style="width:98%;padding:1%;" src="novice_slike/';
					if (empty($row['news_picture']) === true) {
						echo 'domov1.png';
					} else {
						echo $row['news_picture'];
					}
					echo '" /></a>';
					echo '<div class="home-info">Datum novice: ' . $news_time . '<br>Avtor novice: ' . $news_user-> first_name . ' ' . $news_user-> last_name . ' (Komentarjev: ' . $num_comments . ')</div>';
					echo '<a style="color:#333;" href="index.php?p=aktualno"><p style="padding:10px;">' . $news_limited . '</p></a><p style="padding:10px;" class="button"><a href="index.php?p=aktualno">Preberi Več...</a></p>';
				}
			}
		?>
	</div>
	<div class="links">
		<p>Povezave:</p>
		<a href="http://www.wkf.net/"><img width="80%" alt="World Karate Federation" title="World Karate Federation" src="/test/Nova_stran/images/wkf.png"></a>
		<a href="http://www.europeankaratefederation.net/"><img width="80%" alt="European Karate Federation" title="European Karate Federation" src="/test/Nova_stran/images/ekf2.png"></a>
		<a href="http://www.olympic.si/"><img width="60%" alt="Olimpijski Komite Slovenije" title="Olimpijski Komite Slovenije" src="/test/Nova_stran/images/oks3.png"></a>
		<a href="http://www.karate-zveza.si/"><img width="100%" alt="Karate Zveza Slovenije" title="Karate Zveza Slovenije" src="/test/Nova_stran/images/kzs1.png"></a>
		<a href="http://www.koper.si/"><img width="100%" alt="Mestna Občina Koper" title="Mestna Občina Koper" src="/test/Nova_stran/images/obcina_koper4.png"></a>
	</div>
		<div class="links">
		<p>Naši sponzorji:</p>
		<a href="http://www.wkf.net/"><img width="80%" alt="World Karate Federation" title="World Karate Federation" src="/test/Nova_stran/images/wkf.png"></a>
		<a href="http://www.europeankaratefederation.net/"><img width="80%" alt="European Karate Federation" title="European Karate Federation" src="/test/Nova_stran/images/ekf2.png"></a>
	</div>