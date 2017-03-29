<?php
include_once $_SERVER["DOCUMENT_ROOT"] . '/test/Nova_stran/inc/classes/usersComment.php';

class Comments {
	public static function emailComments($newsId, $email, $newsTitle, $comment, $username) {
		$sql = "SELECT * FROM comments WHERE connect_id = $newsId";
		$query = mysql_query($sql);

		if ($query) {
			$mail = email($email, 'Komentar je dodan k novici: ' . $newsTitle, '<p>Komentar je dodan k novici z naslovom:</p><h2>' . $newsTitle . '</h2><p>Komentar je dodal: <strong>' . $username . '</strong></p><p>Njegov komentar je:</p><h3>' . $comment . '</h3><br>Če se želite odjaviti od prejemanja e-pošte pojdite na spodnjo povezavo:<br>http://localhost/test/Nova_stran/odjava_email.php?email=' . $email . '&sendmail=1<br>');
		}
		return $mail;
	}
	public static function getNumComments($newsId, $type) {
		$sql = "SELECT * FROM comments WHERE connect_id = $newsId AND type = $type";
		$query = mysql_query($sql);

		if ($query) {
			$num_comments = mysql_num_rows($query);
		}
		return $num_comments;
	}
	public static function getComments($type) {
		$output = array();
		$sql = "SELECT * FROM comments WHERE type = $type ORDER BY time DESC";
		$query = mysql_query($sql);

		if ($query) {
			if (mysql_num_rows($query) > 0) {
				while ($row = mysql_fetch_object($query)) {
					$output[] = $row;
				}
			}
		}
		return $output;
	}
	public static function insert($userId, $connect, $type, $date, $comment) {
		$comment = addslashes($comment);
		$sql = "INSERT INTO `comments` (`user_id`, `connect_id`, `type`, `time`, `comment`) VALUES ('$userId', '$connect', '$type', '$date', '$comment')";
		$query = mysql_query($sql);

		if ($query) {
			$insert_id = mysql_insert_id();

			$std = new stdClass();
			$std-> comment_id = $insert_id;
			$std-> userId = (int)$userId;
			$std-> connect = $connect;
			$std-> type = $type;
			$std-> date = $date;
			$std-> comment = $comment;

			return $std;
		}
		return null;
	}
	public static function delete($commentId) {
		$sql = "DELETE FROM comments WHERE comment_id = $commentId";
		$query = mysql_query($sql);

		if ($query) {
			return true;
		}
		return null;
	}
	public static function getNews($newsId) {
		$sql = "SELECT * FROM news WHERE news_id = $newsId";
		$query = mysql_query($sql);

		if ($query) {
			if (mysql_num_rows($query) == 1) {
				return mysql_fetch_object($query);
			}
		}
		return null;
	}
}
?>