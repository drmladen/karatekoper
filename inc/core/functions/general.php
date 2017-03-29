<?php
function email($to, $subject, $body, $picture, $pdf) {
	$mail = new PHPMailer;

	$mail->CharSet = 'UTF-8';
	$mail->isSMTP();						// Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';			// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;					// Enable SMTP authentication
	$mail->Username = 'karatekoper@gmail.com';	// SMTP username
	$mail->Password = 'shotokan123';		// SMTP password
	$mail->SMTPSecure = 'ssl';				// Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;						// TCP port to connect to

	$mail->setFrom('karatekoper@gmail.com', 'Karate Klub Koper');
	$mail->addAddress($to);
	
	$mail->addAttachment($picture);			// Add attachments
	$mail->addAttachment($pdf);				// Add attachments

	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);					// Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = $body;

	if(!$mail->send()) {
	    echo 'E-pošto nismo uspeli poslati!';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    echo 'E-pošta je bila uspešno poslana!';
	}
}

function logged_in_redirect() {
	if (logged_in() === true) {
		header('Location: index.php');
		exit();
	}	
}

function protect_page() {
	if (logged_in() === false) {
		header('Location: index.php?p=safe');
		exit();
	}	
}

function admin_protect() {
	global $user_data;
	if (has_access($user_data['user_id'], 1) === false) {
		header('Location: index.php');
		exit();
	}
}

function moderator_protect() {
	global $user_data;
	if (has_access($user_data['user_id'], 2) === false) {
		header('Location: index.php');
		exit();
	}
}

function all_protect() {
	global $user_data;
	if (has_access($user_data['user_id'], 1) === false && has_access($user_data['user_id'], 2) === false) {
		header('Location: index.php');
		exit();
	}
}

function array_sanitize(&$item) {
	$item = htmlentities(strip_tags(mysql_real_escape_string($item)));
}

function sanitize($data) {
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}

function output_errors($errors) {
	return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
}
?>