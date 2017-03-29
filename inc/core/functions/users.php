<?php
function change_profile_image($user_id, $file_temp, $file_extn) {
	$file_path = 'profilne_slike/profile/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
	move_uploaded_file($file_temp, $file_path);
	mysql_query("UPDATE `users` SET `profile` = '" . mysql_real_escape_string($file_path) . "' WHERE `user_id` =" . (int)$user_id);
}

function mail_users($subject, $body) {
	$query = mysql_query("SELECT `email`, `first_name`, `last_name`, `sendmail` FROM `users` WHERE `sendmail` = 1");
	while (($row = mysql_fetch_assoc($query)) !== false) {
		email($row['email'], $subject, "Pozdravljeni " . $row['first_name'] . " " . $row['last_name'] . ",<br><br>" . $body . "<br><br>Karate klub Koper<br>Prade - cesta X/008<br>6000 Koper<br>Slovenija<br>+386 40 643 460 (Mladen)<br>www.karatekoper.com<br>Če se želite odjaviti od prejemanja e-pošte pojdite na spodnjo povezavo:<br>http://localhost/test/Nova_stran/odjava_email.php?email=" . $row['email'] . "&sendmail=" . $row['sendmail'] . "<br>");
	}
}

function has_access($user_id, $type) {
	$user_id 	= (int)$user_id;
	$type 		= (int)$type;
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = $user_id AND `type` = $type"), 0) == 1) ? true : false;
}

function recover($mode, $email) {
	$mode 		= sanitize($mode);
	$email 		= sanitize($email);
	
	$user_data 	= user_data(user_id_from_email($email), 'user_id', 'first_name', 'last_name', 'username');
	
	if ($mode == 'username') {
		email($email, 'Vaše uporabniško ime!', "Pozdravljeni " . $user_data['first_name'] . " " . $user_data['last_name'] . ",<br><br>Vaše uporabniško ime je: " . $user_data['username'] . "<br><br>-karatekoper.com");
	} else if ($mode == 'password') {
		$generated_password = substr(md5(rand(999, 999999)), 0, 14);
		change_password($user_data['user_id'], $generated_password);
		
		update_user($user_data['user_id'], array('password_recover' => '1'));
		 
		email($email, 'Vaše novo geslo!', "Pozdravljeni " . $user_data['first_name'] . " " . $user_data['last_name'] . ",<br><br>Vaše novo geslo je: " . $generated_password . "<br><br>Zaradi varnostnih razlogov boste morali ob prvi prijavi spremeniti zgornje geslo!<br><br>www.karatekoper.com");
	}
}

function update_user($user_id, $update_data) {
	$update = array();
	array_walk($update_data, 'array_sanitize');

	foreach ($update_data as $field=>$data) {
		$update[] = '`' . $field . '` = \'' . $data . '\'';
	}

	mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id");
}

function activate($email, $email_code) {
	$email 		= mysql_real_escape_string($email);
	$email_code	= mysql_real_escape_string($email_code);
	
	if (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code' AND `active` = 0"), 0) == 1) {
		mysql_query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
		return true;
	} 
	else {
		return false;	
	}
}

function unsubscribe($email, $sendmail) {
	$email = mysql_real_escape_string($email);
	$sendmail = mysql_real_escape_string($sendmail);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `sendmail` = '$sendmail' AND `sendmail` = 1");
	
	if (mysql_result($query, 0) == 1) {
		mysql_query("UPDATE `users` SET `sendmail` = 0 WHERE `email` = '$email'");
		return true;
	} 
	else {
		return false;	
	}
}

function change_password($user_id, $password) {
	$user_id = (int)$user_id; 
	$password = md5($password);
	
	mysql_query("UPDATE `users` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = $user_id");
}

function register_user($register_data) {
	array_walk($register_data, 'array_sanitize');
	$register_data['password'] = md5($register_data['password']);
	
	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';
	
	mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
	email($register_data['email'], 'Aktivirajte svoj račun', "Spoštovani " . $register_data['first_name'] . " " . $register_data['last_name'] . ",<br><br>Z klikom na spodnjo povezavno boste aktivirali Vaš račun na naši internetni strani. S tem Vam ponujamo številne možnosti, ki jih lahko uporabljajo le naši registrirani člani. Obljubljamo Vam, da osebnih podatkov ne bomo zlorabiljali. Vi pa morate upoštevati naša pravila sodelovanja. V nasprotnem primeru si bomo prilastili pravico deaktiviranja Vašega računa.<br><br>http://localhost/test/Nova_stran/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "<br><br>Predsednik Karate kluba Koper<br>Mladen Railić");
}

function user_count() {
	return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE  `active` = 1"), 0);
}

function user_data($user_id) {
	$data = array();
	$user_id = (int)$user_id;
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1) {
		unset($func_get_args[0]);
				
		$fields = '`' . implode('`, `', $func_get_args) . '`';
		$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id"));

		return $data;
	}
}

function logged_in() {
	return (isset($_SESSION['user_id'])) ? true : false;
}

function user_exists($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
	return (mysql_result($query, 0) == 1) ? true : false;	
}

function email_exists($email) {
	$email = sanitize($email);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");
	return (mysql_result($query, 0) == 1) ? true : false;	
}

function user_active($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `active` = 1");
	return (mysql_result($query, 0) == 1) ? true : false;	
}

function user_id_from_username($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'"); 
	return (mysql_result($query, 0, 'user_id'));
}

function user_id_from_email($email) {
	$email = sanitize($email);
	$query = mysql_query("SELECT `user_id` FROM `users` WHERE `email` = '$email'"); 
	return (mysql_result($query, 0, 'user_id'));
}

function login($username, $password) {
	$user_id = user_id_from_username($username); 
	
	$username = sanitize($username);
	$password = md5($password);
	
	$query = mysql_query("SELECT COUNT('user_id') FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
	return (mysql_result($query, 0) == 1) ? $user_id : false;
}
function register_news($register_news) {
	array_walk($register_news, 'array_sanitize');

	$upload_pdf = $_FILES['news_link']['name'];
	$upload_img = $_FILES['news_picture']['name'];

	move_uploaded_file($_FILES["news_link"]["tmp_name"],'pdf_datoteke/'.$upload_pdf);
    move_uploaded_file($_FILES["news_picture"]["tmp_name"],'novice_slike/'.$upload_img);

    $images = 'novice_slike/'.$upload_img;
    $pdf = 'pdf_datoteke/'.$upload_pdf;
	
	$fields = '`' . implode('`, `', array_keys($register_news)) . '`';
	$data = '\'' . implode('\', \'', $register_news) . '\'';
	
	mysql_query("INSERT INTO `news` ($fields) VALUES ($data)");

	$query = mysql_query("SELECT `email`, `first_name`, `last_name`, `email`, `sendmail` FROM `users` WHERE `sendmail` = 1");
	
	while (($row = mysql_fetch_assoc($query)) !== false) {
		$sql = mysql_query("SELECT * FROM `news` ORDER BY `news_id` DESC LIMIT 1");
		while (($row_news = mysql_fetch_assoc($sql)) !== false) {
			//email($row['email'], nl2br($row_news['news_title']), 'Pozdravljen ' . $row['first_name'] . ' ' . $row['last_name'] . ',<br><br>Na naši internetni strani je bila dodana naslednja novica:<br><h1>' . nl2br($row_news['news_title']) . '</h1><h5>' . nl2br($row_news['news']) . '</h5>Karate klub Koper<br>Prade - cesta X/008<br>6000 Koper<br>Slovenija<br>+386 40 643 460 (Mladen)<br>www.karatekoper.com<br>Če se želite odjaviti od prejemanja e-pošte pojdite na spodnjo povezavo:<br>http://localhost/test/Nova_stran/odjava_email.php?email=' . $row['email'] . '&sendmail=' . $row['sendmail'] . '<br>', $images, $pdf);
		}
	}
}
function update_news() {
	$news_link 			= $_FILES['news_link']['name'];
	$news_link 			= sanitize($news_link);
	$news_picture 		= $_FILES['news_picture']['name'];
	$news_picture 		= sanitize($news_picture);
	$news_title 		= $_POST['news_title'];
	$news_title 		= sanitize($news_title);
	$news 				= $_POST['news'];
	$news 				= sanitize($news);
	$picture_comment 	= $_POST['picture_comment'];
	$picture_comment 	= sanitize($picture_comment);
	$picture_author 	= $_POST['picture_author'];
	$picture_author 	= sanitize($picture_author);

	if (empty($_FILES['news_link']['name']) === false) {
		mysql_query("UPDATE `news` SET `news_link` = '$news_link' WHERE `news_id` = $_POST[news_id]");

		move_uploaded_file($_FILES['news_link']['tmp_name'], 'pdf_datoteke/'.$news_link);

		unlink($link_path);
	}
	if (empty($_FILES['news_picture']['name']) === false) {
		mysql_query("UPDATE `news` SET `news_picture` = '$news_picture' WHERE `news_id` = $_POST[news_id]");

		move_uploaded_file($_FILES['news_picture']['tmp_name'], 'novice_slike/'.$news_picture);
	}

	mysql_query("UPDATE `news` SET `news_title` = '$news_title', `news` = '$news', `picture_comment` = '$picture_comment', `picture_author` = '$picture_author' WHERE `news_id` = $_POST[news_id]");
}
?>