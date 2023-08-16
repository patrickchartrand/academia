<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Lab Work 1</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
        <link rel="icon" type="image/jpg" href="images/logo.png"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	</head>
	<body>
		<header>
			<?php
				echo "<h1>Informations météorologiques</h1>";

				date_default_timezone_set("America/New_York");
				setlocale(LC_TIME, "fr_FR");
				echo strftime("<h2>Le %A %d %B %Y - %T</h2>");
			?>
		</header>