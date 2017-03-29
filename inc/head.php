<!DOCTYPE html> 
<head>
	<meta charset="utf-8"> 
		<meta name="description" content="<?php echo $pdescription; ?>"> 
		<meta name="keywords" content="<?php echo $keywords; ?>"> 
		<meta name="author" content="Mladen Railić"> 
		<title><?php print $ptitle ?></title> 
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link rel="icon" type="image/png" href="/test/Nova_stran/images/favicon.png">
		<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
		<script type="text/javascript" src="jquery/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery1.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<link rel="stylesheet" href="gallery_func/source/jquery.fancybox.css?v=2.1.6" type="text/css" media="screen" />
		<script type="text/javascript" src="gallery_func/source/jquery.fancybox.pack.js?v=2.1.6"></script>
		<link rel="stylesheet" href="gallery_func/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
		<script type="text/javascript" src="gallery_func/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<script type="text/javascript" src="gallery_func/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

</head>
<body><div class="color"></div>
<nav class="sticky-signup">
<a class="sticky-signup" href="/test/Nova_stran/index.php">Karate Klub Koper</a>
<?php 
	if (logged_in() === true) {
		include 'inc/logged_in.php';
	} else {
		include 'inc/sticky_menu.php';
	}
?>
</nav>
<?php include 'inc/header_img.php'; ?>
<div class="page-wrap">