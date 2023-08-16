<?php

if ($_POST['action']=='soumettre')

{
	try
	{
		//Ouverture de la base de données
		include '../App_Data/ouverture_bd.php';

		//Requête SQL pour enregistrer de nouvelles données
$requete_ajout = $bdd->prepare('INSERT INTO ensg2 (matr, prenom, nom, profil, arrivee, depart, agreg, titul, notes_e) VALUES (:matr, :prenom, :nom, :profil, :arrivee, :depart, :agreg, :titul, :notes_e);');


//Exécution de la requête et définition des variables

$requete_ajout->execute(array('matr' => $_POST['matr'], 'prenom' => $_POST['prenom'], 'nom' => $_POST['nom'], 'profil' => $_POST['profil'], 'arrivee' => $_POST['arrivee'], 'depart' => (@$_POST['depart']?$_POST['depart']:NULL), 'agreg' => (@$_POST['agreg']?$_POST['agreg']:NULL), 'titul' => (@$_POST['titul']?$_POST['titul']:NULL), 'notes_e' => (@$_POST['notes_e']?$_POST['notes_e']:NULL)));


//  fermeture de la requête

$requete_ajout->closeCursor();

//  fermeture de la base de données

$bdd=null;

}   CATCH(PDOException $e)
		{echo $e;

}
}

?>

<!--Enregistrer le nouvel enseignant-->



<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Saisie des informations sur les nouveaux enseignants</title>
		<meta name="author" content="Andréanne Boisjoli" />
		<meta name="description" content="Formulaire pour l'ajout de nouveaux enseignants" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="icon" type="image/ico" href="../images/favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<!-- Inclusion d'une feuille de styles personnalisée -->
		<?php include '../css/css_modifications.txt' ?>

		<script>

		// Fonction pour l'activation de la fonctionnalité Tooltips de Bootstrap
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});

		// Fonction pour désactiver AGREG et TITUL si chargé de cours
		function ccours() {
			document.getElementById('agreg').setAttribute('disabled', 'disabled');
			document.getElementById('titul').setAttribute('disabled', 'disabled');
		}

		// Fonction pour activer AGREG et TITUL si prof
		function prof() {
			document.getElementById('agreg').removeAttribute('disabled');
			document.getElementById('titul').removeAttribute('disabled');
		}

		</script>

	</head>

	<body>

		<div class="container-fluid">

			<!-- Entête de page fixe -->
			<header class="row navbar-fixed-top">
				<div class="container-fluid">
					<h1><a style="color:#ffffff;" href="../index.php">École des Sciences de l'Information Essentielle</a></h1>
				</div>
			</header>

			<!-- Zone centrale -->
			<div class="row content">

				<!-- Barre de navigation verticale gauche -->
				<div class="col-sm-3 sidenav">

					<nav class="navbar navbar-default">

						<!-- Image dans la barre de navigation (logo de la BD) -->
						<div class="navbar-header">
						  <a href=".."><img class="img-thumbnail" src="../images/information.jpg" alt="stages" /></a>
						</div>

						<!-- Éléments de navigation -->
						<div style="width:93%;margin:auto;">

							<ul class="nav navbar-nav">
								<!-- Menu déroulant de navigation pour Module Édition -->
								<li class="small dropdown">
									<a class="dropdow-toggle" data-toggle="dropdown" href="#">Module Édition<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li class="small"><a href="programmes.php">Programmes</a></li>
										<li class="small"><a href="cours.php">Cours</a></li>
										<li class="small"><a href="#">Enseignants</a></li>
										<li class="small"><a href="cohortes.php">Cohortes</a></li>
									</ul>
								</li>
								<!-- Menu déroulant de navigation pour Module Visualisation -->
								<li class="small dropdown">
									<a class="dropdow-toggle" data-toggle="dropdown" href="#">Module Visualisation<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li class="small"><a href="../publication/bilan.php">Bilan ESCIE</a></li>
										<li class="small"><a href="../publication/description_programmes.php">Description Programmes</a></li>
										<li class="small"><a href="../publication/description_cours.php">Description Cours</a></li>
										<li class="small"><a href="../publication/recherche_enseignants.php">Recherche Enseignants</a></li>
										<li class="small"><a href="../publication/recherche_cours.php">Recherche Cours</a></li>
									</ul>
								</li>
							</ul>

						</div>

					</nav>

				</div>

				<!-- Corps de la page -->
				<div class="col-sm-9">

					<!-- FORMULAIRE À L'HORIZONTAL -->
					<form class="form-horizontal" id="formulaire_enseignant" name="formulaire_enseignant" method="post" action="enseignants.php">

						<!-- Barre de navigation horizontale -->

						<div id="edition_programme" class="panel panel-default">

							<div class="panel-heading"><strong>Saisie des informations sur les nouveaux enseignants</strong></div>

							<div class="panel-body">

								<!-- ZONE POUR L'AFFICHAGE DES CONTRÖLES -->
								<label class="control-label col-sm-3 obligatoire">Matricule</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" maxlength="16"  id="matr" name="matr" pattern="[A-Za-z]{4}[0-9]{2}-\[0-9]{2}-\[0-9]{4}-\[0-9]" title="Format&nbsp;:&nbsp;AAAA00-00-0000-0"  required="required" />
								</div>
								<label class="control-label col-sm-3 obligatoire">Prénom</label>
							 	<div class="col-sm-9">
									<input type="text" class="form-control" maxlength="50" id="prenom" name="prenom"  required="required" />
								</div>
									<label class="control-label col-sm-3 obligatoire">Nom de famille</label>
								<div class="col-sm-9">
										<input type="text" class="form-control" maxlength="50" id="nom" name="nom"  required="required" />
								</div>
									<label class="control-label col-sm-3 obligatoire">Profil :</label>
									<div class="col-sm-9">
									<ul style="list-style-type:none;">
										<li><input type="radio" id="profil-p" name="profil" value="p" onclick="prof();"><label for="profil-p">&nbsp;&nbsp;Professeur</label></li>
										<li><input type="radio" id="profil-c" name="profil" value="c" onclick="ccours();"><label for="profil-c">&nbsp;&nbsp;Chargé de cours</label></li>
									</ul>
								</div>

									<p><label class="control-label col-sm-3 obligatoire">Date d'arrivée</label>
										<input type="text" maxlength="10" size="10" id="arrivee" name="arrivee" placeholder="AAAA-MM-JJ" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" required="required" /></p>

									<p><label class="control-label col-sm-3">Année de départ</label>
									<input type="text" maxlength="4" size="4" id="depart" name="depart" placeholder="AAAA" pattern="[0-9]{4}"  /></p>

									<p><label class="control-label col-sm-3">Année d'aggrégation</label>
									<input type="text" maxlength="4" size="4" id="agreg" name="agreg" placeholder="AAAA" pattern="[0-9]{4}" /></p>

									<p><label class="control-label col-sm-3">Année de tiularisation</label>
									<input type="text" maxlength="4" size="4" id="titul" name="titul" placeholder="AAAA" pattern="[0-9]{4}" /></p>

									<label class="control-label col-sm-3">Notes</label>
									<div class="col-sm-9">
										<textarea class="form-control" maxlength="1000" rows="4" cols="100" id="notes_e" name="notes_e" ></textarea>
									</div>
									<input class="btn btn-success navbar-btn" type='submit' value='Soumettre' id='soumettre' name='action'/>

							</div>
						</div>

					</form>

				</div>
			</div>

			<!-- Pied de page fixe -->
			<?php include '../footer.htm';?>

		</div>
	</body>

</html>
