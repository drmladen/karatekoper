<div>

	<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/core/init.php';
	require_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/classes/comments.php';

	if (logged_in() === true) {
		echo '
		<form action="" method="post" enctype="multipart/form-data" class="comments" id="comments">
				<img src="images/head.png">
				<textarea id="comment_area" class="comment-area" name="comment" placeholder="Dodajte svoj komentar tukaj..."></textarea>
				<input type="hidden" id="type" name="type" value="0">
				<input type="hidden" id="userId" value="' . $user_data['user_id'] . '">
				<input type="hidden" id="userName" value="' . $user_data['username'] . '">
				<input type="submit" id="comment_btn" class="comment-btn" name="comments" value="Objavi">
				<input type="hidden" id="newsId" name="news_id" value="">
		</form>';
		}
		?></div>