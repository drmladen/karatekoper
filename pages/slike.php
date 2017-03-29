<div class="text">
	<br><h1 class="hover" align="center">Galerija z albumi 
	<?php
		global $user_data;

		if (has_access($user_data['user_id'], 1) === true || has_access($user_data['user_id'], 2) === true) {
			echo "(Dodaj nov <a href=\"album.php\">Album</a>)";
		}
	?></h1><br><br>
	<?php
	$albums = get_albums();
	
	if (empty($albums)) {
		echo '<br><h2 align="center">Na naši internetni strani še ni dodanih nobenih Albumov!</h2><br><br>';
	} else {
		foreach ($albums as $album) {
			global $user_data;
			$user_name = user_data($album['user_id'], 'username', 'first_name', 'last_name');
			$album_time = date_format(date_create($album['time']), 'd.m.Y, H:i');
			$imageDir = 'galerija/thumbs/' . $album['album_id'];
			$open = glob($imageDir . '/*.*');
			$random = array_rand($open);
			$album_data = album_data($album['album_id'], 'description');
			$num_comments = Comments::getNumComments($album['album_id'], 1);
			$images = get_image($album['album_id']);

			echo '<div class="album" id="del' . $album['album_id'] . '">
				<a href="view_album.php?album_id=' . $album['album_id'] . '"><img class="rotate" id="rotatingImage" src="';
			if (empty($images) === false) {
				$rand = $open[$random];
				echo $rand;
			} else {
				echo 'images/ni_slike.jpg';
			}
			echo '" alt="NI SLIKE"></a>';
			if (has_access($user_data['user_id'], 1) || has_access($user_data['user_id'], 2)) {
				echo '<div class="album-button">(<a href="edit_album.php?album_id=' . $album['album_id'] . '">Uredi album</a> / <a class="del" id="' . $album['album_id'] . '" href="">Izbriši album)</a></div>';
			}
			echo '<a href="view_album.php?album_id=' . $album['album_id'] . '"><h3>' . $album['name'] . '</h3></a>
				<div class="home-info">Datum albuma: ' . $album_time . '<br>Avtor albuma: ' . $user_name['first_name'] . ' ' .  $user_name['last_name'] . ' (Komentarjev: ' . $num_comments . ')<br>Fotograf: ' . $album['fotograf'] . ' (Št. slik: ' . $album['count'] . ')</div>
				<a href="view_album.php?album_id=' . $album['album_id'] . '"><p>' . $album_data['description'] . '</p></a>
				</div><br>';
		}
		echo '<br>';	
	}
	?>
	</div>
</div>