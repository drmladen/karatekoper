<?php 
function upload_image($image_temp, $image_ext, $album_id) {
	$album_id = (int)$album_id;
	$time = date('Y-m-d H:i:s');
	
	mysql_query("INSERT INTO `images` (`user_id`, `album_id`, `time`, `ext`) VALUES ('". $_SESSION['user_id'] ."', '$album_id', '$time', '$image_ext')"); 
	
	$image_id = mysql_insert_id();
	$image_file = $image_id.'.'.$image_ext;
	move_uploaded_file($image_temp, 'galerija/'.$album_id.'/'.$image_file);
	
	create_thumb('galerija/'.$album_id.'/', $image_file, 'galerija/thumbs/'.$album_id.'/');
}

function get_image($album_id) {
	$album_id = (int)$album_id;
	
	$images = array(); 
	
	$image_query = mysql_query("SELECT * FROM `images` WHERE `album_id`= $album_id");
	while ($images_row = mysql_fetch_assoc($image_query)) {
		$images[] = array(
			'image_id'	=> $images_row['image_id'], 
			'album_id' 	=> $images_row['album_id'],
			'time' 		=> $images_row['time'],
			'ext' 		=> $images_row['ext']
		);
	}
	return $images;
}

function delete_image($image_id) {
	$image_id = (int)$image_id;
	
	$image_query = mysql_query("SELECT `album_id`, `ext` FROM `images` WHERE `image_id`=$image_id AND `user_id`=".$_SESSION['user_id']);
	$image_result = mysql_fetch_assoc($image_query);
	
	$album_id = $image_result['album_id'];
	$image_ext = $image_result['ext'];
	
	unlink('galerija/'.$album_id.'/'.$image_id.'.'.$image_ext);
	unlink('galerija/thumbs/'.$album_id.'/'.$image_id.'.'.$image_ext);
	
	mysql_query("DELETE FROM `images` WHERE `image_id`=$image_id AND `user_id`=".$_SESSION['user_id']);
}

function image($image_id) {
	$image_id = (int)$image_id;
	
	$image_query = mysql_query("SELECT `ext` FROM `images` WHERE `image_id`= $image_id");

	return mysql_result($image_query, 0);

}

function image_al($image_id, $album_id) {
	$image_id = (int)$image_id;
	
	$image_query = mysql_query("SELECT `ext` FROM `images` WHERE `image_id`= $image_id AND `album_id` = $album_id");

	return mysql_result($image_query, 0);

}
?>