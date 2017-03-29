<?php
	$connect_error = 'Oprostite, priča ste težavam s povezavo!';
	mysql_pconnect("localhost", "root", "") or die($connect_error);
	mysql_select_db("nova_stran") or die($connect_error);
	//to preden začneš vstavi v phpmyadmin zaradi (čćžđš)
	//ALTER DATABASE `dbname` CHARACTER SET `utf8` COLLATE `utf8_general_ci`;
	//ALTER TABLE `tablename` CONVERT TO CHARACTER SET `utf8` COLLATE `utf8_general_ci`;
?>