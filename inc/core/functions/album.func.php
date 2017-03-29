<?php 
function album_data($album_id) {
	$album_id = (int)$album_id;
	
	$args = func_get_args();
	unset($args[0]); 
	$fields = '`'.implode('`, `', $args).'`';
	
	$query = mysql_query("SELECT $fields FROM `albums` WHERE `album_id`=$album_id");
	$query_result = mysql_fetch_assoc($query); 
	foreach ($args as $field) {
		$args[$field] = $query_result[$field];
	}
	return $args;
}

function video_data($video_id) {
	$video_id = (int)$video_id;
	
	$args = func_get_args();
	unset($args[0]); 
	$fields = '`'.implode('`, `', $args).'`';
	
	$query = mysql_query("SELECT $fields FROM `video` WHERE `video_id`=$video_id");
	$query_result = mysql_fetch_assoc($query); 
	foreach ($args as $field) {
		$args[$field] = $query_result[$field];
	}
	return $args;
}

function get_albums() {
	$albums = array(); 
	
	$album_query = mysql_query("SELECT `albums`.`album_id`, `albums`.`User_id`, `albums`.`time`, `albums`.`name`, LEFT(`albums`.`description`, 50) as `description`, `albums`.`fotograf`, COUNT(`images`.`image_id`) as `image_count` FROM `albums` LEFT JOIN `images` ON `albums`.`album_id` = `images`.`album_id` GROUP BY `albums`.`album_id` DESC");
	
	while ($album_row = mysql_fetch_assoc($album_query)) {
		$albums[] = array(
					'album_id'		=> $album_row['album_id'],
					'user_id'		=> $album_row['User_id'],
					'time' 			=> $album_row['time'],
					'name' 			=> $album_row['name'],
					'description' 	=> $album_row['description'],
					'fotograf'		=> $album_row['fotograf'],
					'count'			=> $album_row['image_count']
		);
	}
	
	return $albums;
}

function get_video() {
	$video = array(); 
	
	$video_query = mysql_query("SELECT * FROM `video` GROUP BY `video_id` DESC");
	
	while ($video_row = mysql_fetch_assoc($video_query)) {
		$video[] = array(
					'video_id'		=> $video_row['video_id'],
					'user_id'		=> $video_row['user_id'],
					'link' 			=> $video_row['link'],
					'time' 			=> $video_row['time'],
					'name' 			=> $video_row['name'],
					'description' 	=> $video_row['description']
		);
	}
	
	return $video;
}

function create_album($album_name, $album_description, $album_fotograf) {
	$album_name = mysql_real_escape_string(htmlentities($album_name));
	$album_description = mysql_real_escape_string(htmlentities($album_description));
	$album_fotograf = mysql_real_escape_string(htmlentities($album_fotograf));
	$time = date('Y-m-d H:i:s');

	mysql_query("INSERT INTO `albums` (`user_id`, `time`, `name`, `description`, `fotograf`) VALUES ('".$_SESSION['user_id']."', '$time', '$album_name', '$album_description', '$album_fotograf')");
	mkdir('galerija/'.mysql_insert_id(), 0777);
	mkdir('galerija/thumbs/'.mysql_insert_id(), 0777); 
}

function edit_album($album_id, $album_name, $album_description, $album_fotograf) {
	$album_id = (int)$album_id; 
	$album_name = mysql_real_escape_string($album_name);
	$album_description = mysql_real_escape_string($album_description);
	$album_fotograf = mysql_real_escape_string($album_fotograf); 
	
	mysql_query("UPDATE `albums` SET `name` = '$album_name', `description` = '$album_description', `fotograf` = '$album_fotograf' WHERE `album_id` = $album_id AND `user_id` = ".$_SESSION['user_id']);
}

function edit_video($video_id, $video_link, $video_name, $video_description) {
	$video_id = (int)$video_id; 
	$video_name = mysql_real_escape_string($video_name);
	$video_description = mysql_real_escape_string($video_description);
	$video_link = mysql_real_escape_string($video_link); 
	
	mysql_query("UPDATE `video` SET `link` = '$video_link', `name` = '$video_name', `description` = '$video_description' WHERE `video_id` = $video_id AND `user_id` = ".$_SESSION['user_id']);
}

function delete_album($album_id) {
	$album_id = (int)$album_id;
	
	$dir = 'galerija/' . $album_id; 
	$dir_thumb = 'galerija/thumbs/' . $album_id;
	
	foreach (scandir($dir) as $item) {
    	if ($item == '.' || $item == '..') continue;
    		unlink($dir . DIRECTORY_SEPARATOR . $item);
		}
	rmdir($dir);
	
	foreach (scandir($dir_thumb) as $item_thumb) {
    	if ($item_thumb == '.' || $item_thumb == '..') continue;
    		unlink($dir_thumb . DIRECTORY_SEPARATOR . $item_thumb);
		}
	rmdir($dir_thumb);
	
	mysql_query("DELETE FROM `albums` WHERE `album_id` = $album_id AND `user_id` = ".$_SESSION['user_id']);
	mysql_query("DELETE FROM `images` WHERE `album_id` = $album_id AND `user_id` = ".$_SESSION['user_id']);
}
?>