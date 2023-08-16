<?php
	include "header.inc.php";


    // GESTION D'ERREUR
    // on observe si une erreur a été retournée
	$url = $_SERVER['REQUEST_URI'];
	$regexp = "error$";
	if(ereg($regexp, $url)) {
		echo "<p style='color:red;'>Veuillez sélectionner une ville.</p>";
	}


	// PRÉSENTATION PRINCIPALE
	// on débute le formulaire
	echo "<main>";
	echo "<form name='formMeteo' action='villes.php' method='GET'><label for='selectMeteo'>Choisir une ville : </label><select name='selectMeteo'>";

	// on fait une connexion au fichier de données
	$file = fopen("http://www.iro.umontreal.ca/~dift1147/pages/TPS/tp1/villes.txt", "r") or exit("Fichier introuvable !");


	// STRUCTURATION DES DONNÉES
	// on récupère les données
	while(!feof($file)) {
		$tmp = explode("; ", $line);
		$opt = explode(":", $tmp[0]);
		$val = explode(":", $tmp[1]);

		// on structure les données dans les options proposées
		echo "<option value='".$opt[1]."&".$val[1]."'>".$opt[1]."</option>";

		// on marque la fin de la lecture du fichier
		$line = fgets($file);
		if($line == "\n") {
			break;
		}
	}


	// ZONE DE FIN
	// on ferme le fichier et le formulaire
	fclose($file);
	echo "</select><img src='images/recherche.png' width='30px'/><br/><button type='submit'>afficher</button></form>";
	echo "<img id='theme' src='images/accueil.png'/></main>";


	include "footer.inc.php";
?>
