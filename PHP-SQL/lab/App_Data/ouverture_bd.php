<?php
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=localhost;dbname=sci6306a19-eq06', 'sci6306a19-eq06', 'BTD9QHTZ', $pdo_options);
	$bdd->exec("SET CHARACTER SET utf8");
?>