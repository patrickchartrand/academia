<?php
	include "header.inc.php";


	// MÉTHODE GET
	// on récupère les informations envoyées
	$link = $_GET['selectMeteo'];
    

    // GESTION D'ERREUR
	// on vérifie qu'une option ait été sélectionnée avant de procéder
	$regexp = "^(.+)\&(.+)$";
	if(ereg($regexp, $link)) {
		/*** valide ***/
	} else {
		header("location: tp1.php?=error");
	}


	// EXTRACTION DES DONNÉES
	// on traite le lien url
	$tmp = explode("&", $link);
	$title = $tmp[0];
	$file = trim($tmp[1]);

	// on indique le titre de la page, c-à-d le nom de la ville
	echo "<main>";
	echo "<h3>".$title."</h3>";

	// on indique le fichier visé
	$data = file("http://www-labs.iro.umontreal.ca/~dift1147/pages/TPS/tp1/".$file);

	// on fait le tableau
	echo "<table>";
	// on manipule les données
	$meteo = array();
	for($i = 0; $i < count($data); $i++) {
		$tmp = explode(": ", $data[$i]);
		$meteo[$tmp[0]] = $tmp[1];
	}

	// on décrit les conditions météorologiques
	if($meteo['temperature']) {
		$meteo['temperature'] = "Température : ".$meteo['temperature'];
		$icon['temperature'] = "<img src='images/temperature.png' width='20px'/>";
	} 
	if ($meteo['humidite']) {
		$meteo['humidite'] = "Humidité : ".$meteo['humidite'];
		$icon['humidite'] = "<img src='images/humidite.png' width='30px'/>";
	} 
	if ($meteo['vent']) {
		$meteo['vent'] = "Vent : ".$meteo['vent'];
		$icon['vent'] = "<img src='images/vent.png' width='30px'/>";
	}

	// on affiche les données
	$image = "<img src='images/".$meteo['information'].".png' alt='".$meteo['information']."' title='".$meteo['information']."' width='80px'/>";
	echo "<table><tr><td>".$image."<br/>".$meteo['information']."</td></tr>";
	echo "<tr><td>".$icon['temperature'].$meteo['temperature']."</td><td>".$icon['humidite'].$meteo['humidite']."</td><td>".$icon['vent'].$meteo['vent']."</td></tr>";
	echo "<tr><td colspan='3'>".$meteo['desc']."</td></tr></table>";

	// on navigue ensuite à l'accueil, et style perso
	echo "<a href='tp1.php'>retour</a>";
	echo "<img id='theme' src='images/animations/".$meteo['information'].".gif'/>";
	echo "</main>";


	include "footer.inc.php";
?>