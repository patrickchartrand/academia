<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Recherche Enseignants</title>
		<meta name="author" content="Christine Dufour" />
		<meta name="description" content="Interface de recherche pour les fiches sur les enseignants." />
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
						<div class="menu_navigation">

							<ul class="nav navbar-nav">
								<!-- Menu déroulant de navigation pour Module Édition -->
								<li class="small dropdown">
									<a class="dropdow-toggle" data-toggle="dropdown" href="#">Module Édition<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li class="small"><a href="../edition/programmes.php">Programmes</a></li>
										<li class="small"><a href="../edition/cours.php">Cours</a></li>
										<li class="small"><a href="../edition/enseignants.php">Enseignants</a></li>
										<li class="small"><a href="../edition/cohortes.php">Cohortes</a></li>
									</ul>
								</li>
								<!-- Menu déroulant de navigation pour Module Visualisation -->
								<li class="small dropdown">
									<a class="dropdow-toggle" data-toggle="dropdown" href="#">Module Visualisation<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li class="small"><a href="bilan.php">Bilan ESCIE</a></li>
										<li class="small"><a href="description_programmes.php">Description Programmes</a></li>
										<li class="small"><a href="description_cours.php">Description Cours</a></li>
										<li class="small"><a href="#">Recherche Enseignants</a></li>
										<li class="small"><a href="recherche_cours.php">Recherche Cours</a></li>
									</ul>
								</li>
							</ul>

						</div>

					</nav>

				</div>

				<!-- Corps de la page -->
				<div class="col-sm-9">

					<h2>Recherche Enseignants</h2>

					<!-- Zone pour la boîte de recherche -->
					<form class="form-horizontal" method="post">

						<!-- Barre de navigation horizontale -->
						<nav class="navbar navbar-inverse">

							<div class="container-fluid">

								<!-- Valeur de la zone de la requête soit vide (lorsque c'est un premier accès à la page), soit avec la requête précédemment exécutée -->
								<span class="etiquette">Recherche dans les prénoms ou noms</span><input class="form-control boite_recherche" type="text" name="requete" id="requete" maxlength="100" required value="<?php echo @$_POST['requete'];?>" />
								<input class="btn btn-success navbar-btn" name="action" id="chercher" type="submit" value="Chercher!" />

							</div>

						</nav>

						<p class="notes"><strong>Syntaxe de recherche</strong> : +<em>mot</em> = <em>mot</em> présent, -<em>mot</em> = <em>mot</em> absent, <em>mot</em> = <em>mot</em> peut être présent, * = troncature</p>

					</form>

					<!-- Zone pour l'affichage des résultats -->

					<div id="resultats_enseignants" class="panel panel-default">

						<?php

						if (@$_POST['requete'])
						{

							// Affichage des fiches des enseignants correspondant à la requête
							try
							{
								// Ouverture de la base de données
								include '../App_Data/ouverture_bd.php';

								// Définition de la requête pour aller chercher les fiches des enseignants. La requête est un peu plus complexe du fait d'avoir voulu minimiser
								// le travail en PHP lors de l'affichage. Par exemple, au lieu de faire une condition en PHP pour remplacer les NULL pour les champs obligatoires,
								// la fonction IFNULL a été utilisée pour faire ce traitement directement en SQL.
								$req_donneesensg = $bdd->prepare('SELECT nom, prenom, ensg2.profil, ensg2.matr, arrivee, ifnull(depart,"n/a") as depart, ifnull(titul,"n/a") as titul, ifnull(agreg,"n/a") as agreg, ifnull(notes_e,"n/a") as notes_e, ifnull((SELECT GROUP_CONCAT(DISTINCT CONCAT(prog2.cycle, "-",prog2.version,"-",prog2.annee_p," ",prog2.titre_p) SEPARATOR "; ") FROM coordonne2, prog2 WHERE coordonne2.matr=ensg2.matr AND coordonne2.cycle=prog2.cycle AND coordonne2.version=prog2.version), "Aucune") AS responsabilite, ifnull((SELECT GROUP_CONCAT(DISTINCT (CONCAT(donne2.sigle," ",cours2.titre_c)) SEPARATOR "; ") FROM donne2, cours2 WHERE donne2.matr=ensg2.matr and ensg2.profil=donne2.profil and donne2.sigle=cours2.sigle), "Aucun") AS "cours enseignes" FROM ensg2 WHERE MATCH (prenom,nom) AGAINST (:requete IN BOOLEAN MODE) ORDER BY matr');

								// Exécution de la requête en injectant dans la variable :requete de la requête SQL ce qui a été saisi dans la boîte du formulaire
								$req_donneesensg->execute(array('requete'=>$_POST['requete']));

								// Mise en mémoire dans la variable $count du nombre d'enregistrements repérés
								$count = $req_donneesensg->rowCount();?>

								<!-- Particularisation du titre de la boîte pour y rappeller la requête ($_POST['requete']), le nombre de résultats obtenus ($count) et la date -->
								<div class="panel-heading"><strong>Résultats de la requête <samp><?php echo @$_POST['requete'];?></samp> / <?php echo ($count==1?"1 résultat":($count==0?"Aucun résultat":$count." résultats"));?> (en date du <?php echo date("j-m-Y H:i:s");?>)</strong></div>

								<!-- Zone de présentation des fiches des enseignants -->
								<div class="panel-body">

									<?php

									// Boucle pour parcourir la table des résultats
									while ($donnees = $req_donneesensg->fetch())
									{

										// Affichage du nom et du statut
										echo "<p><strong>".$donnees['matr']." ".$donnees['prenom']." ".$donnees['nom']." (".($donnees['profil']=="c"?"Chargé de cours":"Professeur").")"."</strong></p>";

										// Condition afin de particulariser l'affichage en fonction du statut
										if ($donnees['profil']=="p")
										{
											echo "<ul>";
											echo "<li><em>Arrivée</em> : ".$donnees['arrivee']."</li>";
											echo "<li><em>Agrégation</em> : ".$donnees['agreg']."</li>";
											echo "<li><em>Titularisation</em> : ".$donnees['titul']."</li>";
											echo "<li><em>Responsabilité de programmes</em> : ".$donnees['responsabilite']."</li>";
											echo "<li><em>Cours enseignés</em> : ".$donnees['cours enseignes']."</li>";
											echo "<li><em>Départ</em> : ".$donnees['depart']."</li>";
											echo "<li><em>Notes</em> : ".$donnees['notes_e']."</li>";
											echo "</ul>";
										}
										else
										{
											echo "<ul>";
											echo "<li><em>Arrivée</em> : ".$donnees['arrivee']."</li>";
											echo "<li><em>Cours enseignés</em> : ".$donnees['cours enseignes']."</li>";
											echo "<li><em>Notes</em> : ".$donnees['notes_e']."</li>";
											echo "</ul>";
										}

									}

									// Fermeture de la requête et de la base de données
									$req_donneesensg->closeCursor();
									$bdd=null;?>

								</div>

								<?php
							}

							// Gestion des erreurs
							catch(Exception $e)
							{
							die('Erreur : '.$e->getMessage());
							}

						}
						?>
					</div>
				</div>
			</div>

			<!-- Pied de page fixe -->
			<?php include '../footer.htm';?>

		</div>
	</body>

</html>
