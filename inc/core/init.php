<?php 
	session_start();
	error_reporting();
	
	require 'database/connect.php';
	require 'functions/general.php';
	require 'functions/users.php';
	require 'functions/album.func.php';
	require 'functions/image.func.php';
	require 'functions/thumb.func.php';
	require 'phpmailer/PHPMailerAutoload.php';

	$current_file = explode('/', $_SERVER['SCRIPT_NAME']);
	$current_file = end($current_file);

	if(logged_in() === true) {
		$session_user_id = $_SESSION['user_id'];
		$user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'first_name', 'last_name', 'birth_date', 'email', 'sendmail', 'password_recover', 'type');
		if (user_active($user_data['username']) === false) {
			session_destroy();
			header('Location: index.php');
			exit();
		}
		if ($current_file !== 'newpassword.php' && $current_file !== 'logout.php' && $user_data['password_recover'] == 1) {
			header('Location: newpassword.php?force');
			exit();
		}
	}

	$errors = array();
?>