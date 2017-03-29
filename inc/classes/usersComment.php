<?php
class Users {
	public static function getUser($userId) {
		$sql = "SELECT * FROM users WHERE user_id = $userId";
		$query = mysql_query($sql);

		if ($query) {
			if (mysql_num_rows($query) == 1) {
				return mysql_fetch_object($query);
			}
		}
		return null;
	}
	public static function emailUser($userId) {
		$sql = "SELECT * FROM users WHERE user_id = $userId AND sendmail = 1";
		$query = mysql_query($sql);

		if ($query) {
			if (mysql_num_rows($query) == 1) {
				return mysql_fetch_object($query);
			}
		}
		return null;
	}
	public static function getUsersId($newsId) {
		$output = array();
		$sql = "SELECT user_id FROM comments WHERE connect_id = $newsId";
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
}
?>