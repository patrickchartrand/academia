<?php
	// Condition pour l'ajout d'un programme dans la base de données, soit le bouton Soumettre
	if ($_POST['action']=="Soumettre") {

    	try {

			// Ouverture de la base de données
			include '../App_Data/ouverture_bd.php';

			// Définition de la requête pour insérer un programme dans la base de données
        	//seule les notes sur le programme en question peuvent être « null » ici
        	$req = $bdd->prepare("INSERT INTO prog2 (titre_p, version, cycle, annee_p, credits, notes_p) VALUES(:titre, :version, :cycle, :annee, :credits, :notes)");

			// Exécution de la requête
        	$req->execute(array('titre'=>$_POST['titre'], 'version'=>$_POST['version'], 'cycle'=>$_POST['cycle'], 'annee'=>$_POST['annee'], 'credits'=>$_POST['credits'], 'notes'=>(@$_POST['notes']?$_POST['notes']:NULL)));

        	// Fermeture de la requête et de la base de données
        	$req->closeCursor();
        	$bdd=null;
    	}

    	// Gestion des erreurs
    	catch(Exception $e) {
    		die('Erreur : '.$e->getMessage());
		}

	}
?>

<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Saisie des informations sur les nouveaux programmes</title>
		<meta name="author" content="Patrick Chartrand" />
		<meta name="description" content="Formulaire pour l'ajout de nouveaux programmes" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="icon" type="image/ico" href="../images/favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<!-- Inclusion d'une feuille de styles personnalisée -->
		<?php include '../css/css_modifications.txt' ?>

		<!-- Pour l'activation de la fonctionnalité Tooltips de Bootstrap -->
		<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
		</script>

	</head>

	<body>

		<div class="container-fluid">

			<!-- Entête de page fixe -->
			<header class="row navbar-fixed-top">
				<div class="container-fluid">
					<h1><a style="color:#ffffff;" href='../index.php'>École des Sciences de l'Information Essentielle</a></h1>
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
										<li class="small"><a href="#">Programmes</a></li>
										<li class="small"><a href="cours.php">Cours</a></li>
										<li class="small"><a href="enseignants.php">Enseignants</a></li>
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
					<form class="form-horizontal" id="formulaire_programme" name="formulaire_programme" method="post" action="programmes.php">

						<div id="edition_programme" class="panel panel-default">

							<div class="panel-heading"><strong>Saisie des informations sur les nouveaux programmes</strong></div>

							<div class="panel-body">

								<!-- Le titre a une seule condition, celle d'un maximum de 57 caractères, est de type texte et obligatoire -->
								<label class="control-label col-sm-3 obligatoire">Titre du programme</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="titre" maxlength="57" required />
								</div>
								<!-- Le choix du cycle s'effectue par des boutons de type radio, qui permettent notamment d'appliquer du javascript par un clique afin d'associer une requête php selon le besoin : à chaque cycle est donc attribué une valeur sélectionnée dans la base de donnée qui est celle correspondant à la dernière version entrée, puis « +1 » pour la nouvelle version en cours; cette portion fait partie du bonus -->
								<!-- Chaque bouton a la valeur du cycle correspondant, sont de type radio et l'un d'eux est obligatoire -->
								<label class="control-label col-sm-3 obligatoire">Cycle</label>

								<!-- Le code php ci-bas vient bonifier le système demandé : c'est qu'il permet d'ajouter un contrôle automatique des entrées de donnée pour chaque version, alors on évite ainsi des problèmes de compatibilité avec les clés primaires composées 'cycle' et 'version', car une version de programme est unique par cycle -->
								<!-- Donc 3 options ici, soit une par cycle -->
								<div class="col-sm-9">
									<ul style="list-style-type:none;">

										<?php
											// OPTION 1
											// Ouverture de la base de données
											include '../App_Data/ouverture_bd.php';

											// Définition de la requête pour sélectionner la dernière version pour le cycle 1
											$req = $bdd->query("SELECT * FROM prog2 WHERE cycle=1 ORDER BY version DESC LIMIT 1");

											// Exécution de la requête
											$req->execute();

        									// Affichage des résultats de la requête
											$cycle1 = $req->fetch();
										?>

										<li><input type="radio" name="cycle" value="1" onclick="document.getElementById('version').value='<?php echo $cycle1['version']+1; ?>';" required /><label>&nbsp;&nbsp;premier</label></li>

										<?php
        									// Fermeture de la requête et de la base de données
											$req->closeCursor();
											$bdd=null;

											// OPTION 2
											// Ouverture de la base de données
											include '../App_Data/ouverture_bd.php';

											// Définition de la requête pour sélectionner la dernière version pour le cycle 2
											$req = $bdd->query("SELECT * FROM prog2 WHERE cycle=2 ORDER BY version DESC LIMIT 1");

											// Exécution de la requête
											$req->execute();

        									// Affichage des résultats de la requête
											$cycle2 = $req->fetch();
										?>

										<li><input type="radio" name="cycle" value="2" onclick="document.getElementById('version').value='<?php echo $cycle2['version']+1; ?>';" /><label>&nbsp;&nbsp;deuxième</label></li>

										<?php
        									// Fermeture de la requête et de la base de données
											$req->closeCursor();
											$bdd=null;

											// OPTION 3
											// Ouverture de la base de données
											include '../App_Data/ouverture_bd.php';

											// Définition de la requête pour sélectionner la dernière version pour le cycle 3
											$req = $bdd->query("SELECT * FROM prog2 WHERE cycle=3 ORDER BY version DESC LIMIT 1");

											// Exécution de la requête
											$req->execute();

        									// Affichage des résultats de la requête
											$cycle3 = $req->fetch();
										?>

										<li><input type="radio" name="cycle" value="3" onclick="document.getElementById('version').value='<?php echo $cycle3['version']+1; ?>';" /><label>&nbsp;&nbsp;troisième</label></li>

										<?php
        									// Fermeture de la requête et de la base de données
											$req->closeCursor();
											$bdd=null;
										?>

									</ul>
								</div>
								<!-- La version est affichée mais elle aurait pu être cachée, puisqu'elle est automatique : or elle est sans possibilité de modification (aucun risque d'erreur) et de type numérique -->
								<p><label class="control-label col-sm-3 obligatoire">Version</label>
									<input id="version" type="text" name="version" size="4" required /></p>
								<!-- L'année ne peut, entre autres, pas être postérieure à l'actuelle, qui se situe dans une tranche d'années définie, est de type numérique et obligatoire; par défaut, c'est l'année actuelle qui est inscrite -->
								<p><label class="control-label col-sm-3 obligatoire">Année</label>
									<input type="text" name="annee" maxlength="4" value="<?php echo date("Y"); ?>" size="4" required /></p>
								<!-- Les crédits ont les conditions dont le nombre est d'un minimum de 1 et d'un maximum de 2, puis est de type numérique et obligatoire -->
								<p><label class="control-label col-sm-3 obligatoire">Crédits</label>
									<input type="text" name="credits" maxlength="2" size="4" placeholder="00" required /></p>
								<!-- Les notes sont d'un maximum de 1000 caractères et de type texte -->
								<label class="control-label col-sm-3">Notes</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="notes" maxlength="300" />
								</div>
								<input class="btn btn-success navbar-btn" type="submit" name="action" value="Soumettre" />
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
