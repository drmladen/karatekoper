<div class="text">
	<br><h1 class="hover" align="center">Galerija posnetkov 
	<?php
		global $user_data;

		if (has_access($user_data['user_id'], 1) === true || has_access($user_data['user_id'], 2) === true) {
			echo "(Dodaj nov Youtube <a href=\"video.php\">Posnetek</a>)";
		}
	?></h1><br><br>
	<?php
		$video = get_video();

		if (empty($video) === true) {
			echo '<br><h2 align="center">Na naši internetni strani še ni dodanih nobenih Youtube Posnetkov!</h2><br><br>';
		} else {
			foreach ($video as $vid) {
				global $user_data;
				$user_name = user_data($vid['user_id'], 'username', 'first_name', 'last_name');
				$video_time = date_format(date_create($vid['time']), 'd.m.Y, H:i');
				$video_id = $vid['video_id'];
				$num_comments = Comments::getNumComments($video_id, 2);

				echo '<div class="album1" id="del' . $vid['video_id'] . '">';
				echo '<iframe src="http://www.youtube.com/embed/' . $vid['link'] . '?rel=0&hd=1" frameborder="0" allowfullscreen></iframe>';
				if (has_access($user_data['user_id'], 1) || has_access($user_data['user_id'], 2)) {
					echo '<div class="album-button">(<a href="edit_video.php?video_id=' . $vid['video_id'] . '">Uredi video</a> / <a href="delete_video.php?video_id=' . $vid['video_id'] . '">Izbriši video)</a></div>';
				}
				#spodaj pa naštimaj stran za ogled videa in komentarje
				echo '<a href="view_video.php?video_id=' . $vid['video_id'] . '"><h3>' . $vid['name'] . '</h3></a>';
				echo '<div class="home-info">Datum videa: ' . $video_time . '<br>Avtor albuma: ' . $user_name['first_name'] . ' ' . $user_name['last_name'] . ' (Komentarjev: ' . $num_comments . ')</div>';
				echo '<a href="view_video.php?video_id=' . $vid['video_id'] . '"><p>' . $vid['description'] . '</p><br><p>Če želite prebrati komentarje ali dodati komentarje pritisnite tukaj!</p></a>';
				echo '</div><br>';
			}
		}
	?>
	<br>
</div>