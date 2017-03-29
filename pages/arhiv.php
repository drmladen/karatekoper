<div class="text">
	<h1 align="center">Arhiv novic:</h1><br>
	<?php
		$sql = mysql_query("SELECT * FROM `news`");

		if (mysql_num_rows($sql) <= 5) {
			echo "<br><h2 align=\"center\">V arhivu ni nobenih novic!</h2><br><br>";	 
		} else {
			global $user_data;

			$sql = mysql_query("SELECT * FROM news ORDER BY news_id DESC LIMIT 5, 10000000");

			while ($row = mysql_fetch_assoc($sql)) {
				echo '<h1>' . $row['news_title'] . '</h1><br>';
				#tu se začne izgled internet novice
				echo '<div class="anews"><table style="border-bottom:3px solid #999;"><tr><td style="width:40%;">';
				echo '<div class="img_div"><a class="fancybox" href="novice_slike/';
				if (empty($row['news_picture']) === true) {
				 	echo 'domov1.png" title="K1 Thermana Laško - Mladen Railić v akciji (Fotograf: Benjamin Žgank)"><img src="novice_slike/domov1.png"></a><p>K1 Thermana Laško - Mladen Railić v akciji (Fotograf: Benjamin Žgank)</p>';
				} else {
				 	echo $row['news_picture'] . '" title="' . $row['picture_comment'] . ' (Fotograf: ' . $row['picture_author'] . ')"><img src="novice_slike/' . $row['news_picture'] . '"></a><p>' . $row['picture_comment'] . ' (Fotograf: ' . $row['picture_author'] . ')</p></div>';
				}
				echo '</div></td><td style="vertical-align:top;"><p style="margin-left:5px;">' . $row['news'] . '</p></div>';
				echo "</td></tr><tr><td class=\"hover\" colspan=\"2\">";
				if (empty($row['news_link']) === false){
					echo "<img style=\"width:30px;padding:0;\" src=\"images/pdf.png\"/>";
				}
				echo "<a style=\"vertical-align:top;margin-left:5px;\" href=\"pdf_datoteke/" . $row['news_link'] . "\" target=\"_blank\">" . $row['news_link'] . "</a></td></tr></table>";
				echo "</div>";
				#tu se začne mobitelov izgled novice
				echo '<div class="anews_mobile"><table style="border-bottom:3px solid #999;"><tr><td>';
				echo '<div class="img_divm">';
				if (empty($row['news_picture']) === true) {
					echo '<a class="fancybox" href="novice_slike/domov1.png" title="K1 Thermana Laško - Mladen Railić v akciji (Fotograf: Benjamin Žgank)"><img src="novice_slike/domov1.png"></a><p>K1 Thermana Laško - Mladen Railić v akciji (Fotograf: Benjamin Žgank)</p></div></td><tr><td style="vertical-align:top;"><p style="margin-left:5px;">' . $row['news'] . '</p>';
				} else {
					echo '<a class="fancybox" href="novice_slike/' . $row['news_picture'] . '" title="' . $row['picture_comment'] . ' (Fotograf: ' . $row['picture_author'] . ')"><img src="novice_slike/' . $row['news_picture'] . '"></a><p>' . $row['picture_comment'] . ' (Fotograf: ' . $row['picture_author'] . ')</p></div></td><tr><td style="vertical-align:top;"><p style="margin-left:5px;">' . $row['news'] . '</p>';
				}
				echo "</div></td></tr><tr><td class=\"hover\" colspan=\"2\">";
				if (empty($row['news_link']) === false){
					echo "<img style=\"width:30px;padding:0;\" src=\"images/pdf.png\"/>";
				}
				echo "<a style=\"vertical-align:top;margin-left:5px;\" href=\"pdf_datoteke/" . $row['news_link'] . "\" target=\"_blank\">" . $row['news_link'] . "</a></td></tr></table></div>";
				#tu se konča mobitelov izgled novic
				if (logged_in() === true) {
				echo '
				<form action="" method="post" enctype="multipart/form-data" class="comments" id="comments">
						<img src="images/head.png">
						<textarea id="comment_area" class="comment-area" name="comment" placeholder="Dodajte svoj komentar tukaj..."></textarea>
						<input type="hidden" id="type" name="type" value="0">
						<input type="hidden" id="userId" value="' . $user_data['user_id'] . '">
						<input type="hidden" id="userName" value="' . $user_data['username'] . '">
						<input type="submit" id="comment_btn" class="comment-btn" name="comments' . $row['news_id'] . '" value="Objavi">
						<input type="hidden" id="newsId" name="news_id" value="' . $row['news_id'] . '">
				</form>';
				}

				$comments = Comments::getComments(0);

				if (isset($GLOBALS['comments']) && is_array($comments)) {
					$news_time = date_format(date_create($row['time']), 'd.m.Y, H:i');
					$news_user = Users::getUser($row['user_id']);
					$news_id = $row['news_id'];
					$num_comments = Comments::getNumComments($news_id, 0);

					echo '<div class="news-info">Datum novice: ' . $news_time . '<br>Avtor novice: ' . $news_user-> first_name . ' ' . $news_user-> last_name . ' (Komentarjev: <p id="num_comments' . $row['news_id'] . '0" class="news-info">' . $num_comments . '</p>)';
					if (logged_in() === false) {
						echo '<br>Če želite dodati komentar se morate prijaviti!';
					}
					echo '</div><div class="comments_see" id="comments_see' . $row['news_id'] . '">';

					foreach ($comments as $key => $comment) {
						$connect = $comment-> connect_id;
						$type = $comment-> type;
						$user = Users::getUser($comment-> user_id);
						$time = date_format( date_create($comment-> time), 'd.m.Y, H:i' );
						
						if ($row['news_id'] == $connect && $type == 0) {
							echo '<div class="' . $row['news_id'] . '" id="comment_list" style="display:none"><div class="count" id="' . $row['news_id'] . '0">';
							echo '<div id="' . $comment-> comment_id . '" class="comments_see1">';
							echo '<div class="profile-img"><img src="';
							echo 'images/head.png';#tu ustavis profilno sliko če obstaja
							echo '"></div><div class="username">';
							echo $user-> username;
							echo ' (';
							echo $time;
							echo ')';
							if (has_access($user_data['user_id'], 1) || has_access($user_data['user_id'], 2) || $user_data['user_id'] == $comment-> user_id) {
								echo '<div id="';
								echo $comment-> comment_id;
								echo '" class="delete-comment">X</div>';
							}
							echo '</div><p class="username-p">';
							echo $comment-> comment;
							echo '</p></div></div></div>';
						}
					}
					echo '<div id="loadMore">Prikaži še komentarjev</div><div class="see-more">Ni več dodatnih komentarjev</div><div id="showLess">Skrij komentarje</div></div><br>';
				}
				echo '<br><br>';
			}
		}
	?>
</div>