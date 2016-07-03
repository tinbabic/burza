<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<title>NasaApp</title>
	<link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
	<h1><?php echo $title; ?></h1>

	<nav>
		<ul>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=users">Popis svih korisnika</a></li>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=firms">Popis svih firmi</a></li>
			<li><a href="<?php echo __SITE_URL; ?>/index.php?rt=saldos">Popis svih salda</a></li>
		</ul>
	</nav>
