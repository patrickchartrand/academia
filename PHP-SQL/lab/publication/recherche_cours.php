<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Recherche Cours</title>
		<meta name="author" content="Patrick Chartrand" />
		<meta name="description" content="Interface permettant de recherche un cours à partir d'un mot du titre ou de la description" />
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
		<!-- Un peu de stylisation personnelle que j'ai mise ici pour des raisons de clarté avec le code déjà fait et la correction -->
		<style>
			/* arrangement stylistique du tableau affichant certaines modalités sur un cours */
			table {
				width: 100%;
				margin-bottom: 100px;
			}
			/* sur le style des colonnes d'entête du tableau */
			th {
				border-bottom: 1.5px solid !important;
				text-align: center;
			}
			/* sur le style des autres colonnes du tableau */
			td {
				border-bottom: 1.5px solid lightgray !important;
				text-align: center;
			}
		</style>
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
										<li class="small"><a href="recherche_enseignants.php">Recherche Enseignants</a></li>
										<li class="small"><a href="#">Recherche Cours</a></li>
									</ul>
								</li>
							</ul>

						</div>

					</nav>

				</div>

				<!-- Corps de la page -->
				<div class="col-sm-9">

					<h2>Recherche Cours</h2>

					<!-- Zone pour la boîte de recherche -->
					<form class="form-horizontal" method="post">

						<!-- Barre de navigation horizontale -->
						<nav class="navbar navbar-inverse">

							<div class="container-fluid">

								<label class="etiquette">Recherche dans titre ou description</label><input class="form-control boite_recherche" type="text" name="requete" id="requete" maxlength="100" required value="<?php echo @$_POST['requete'];?>" />
								<input class="btn btn-success navbar-btn" name="action" id="chercher" type="submit" value="Chercher" />

							</div>

						</nav>

						<p class="notes"><strong>Syntaxe de recherche</strong> : +<em>mot</em> = <em>mot</em> présent, -<em>mot</em> = <em>mot</em> absent, <em>mot</em> = <em>mot</em> peut être présent, * = troncature</p>

					</form>

					<!-- Zone pour l'affichage des résultats -->

					<div id="resultats_cours" class="panel panel-default">

						<?php
							if (@$_POST['requete']) {

								// Affichage de la recherche de cours
								try {

									// Ouverture de la base de données
									include '../App_Data/ouverture_bd.php';

									// Récupération du mois actuel, ce qui permet aux données de correspondre très précisément à la session active de l'utilisateur, en plus de l'année
									$mois_actuel = date('m');
									// Répartition des mois par saison trimestrielle : les 4 premiers constituent l'hiver; les 4 suivants; l'été; et les 4 restants, l'automne
									if ($mois_actuel <= '4')
									$saison = 'H';
									elseif ($mois_actuel >= '9')
									$saison = 'A';
									else
									$saison = 'E';

									// Définition de la requête pour rechercher un cours par titre et description et pour sélectionner toutes les données relatives au cours recherché
									$req_donneescours = $bdd->prepare("SELECT titre_c, descr, cours2.sigle, donne2.annee, CASE WHEN donne2.trimestre='H' THEN 'hiver' WHEN donne2.trimestre='A' THEN 'automne' ELSE 'été' END AS 'trimestres', donne2.nbre_et, CASE WHEN donne2.mode='p' THEN 'présentiel' WHEN donne2.mode='d' THEN 'à distance' ELSE 'mixte' END AS 'modes', ensg2.prenom, ensg2.nom, CASE WHEN offre2.statut='OB' THEN 'obligatoire' ELSE 'optionnel' END AS 'statuts', prog2.titre_p, CASE WHEN prog2.cycle=2 THEN '2<sup>ème</sup>' WHEN prog2.cycle=3 THEN '3<sup>ème</sup>' ELSE '1<sup>er</sup>' END AS 'cycles' FROM cours2 INNER JOIN donne2 ON cours2.sigle=donne2.sigle INNER JOIN ensg2 ON donne2.matr=ensg2.matr INNER JOIN offre2 ON cours2.sigle=offre2.sigle INNER JOIN prog2 ON offre2.version=prog2.version AND offre2.cycle=prog2.cycle WHERE donne2.trimestre='$saison' AND donne2.annee=YEAR(CURRENT_DATE) AND MATCH (titre_c, descr) AGAINST (:requete IN BOOLEAN MODE) GROUP BY ensg2.matr ORDER BY titre_c ASC");

									// Exécution de la requête
									$req_donneescours->execute(array('requete'=>$_POST['requete']));

									// Mise en mémoire dans la variable $count du nombre d'enregistrements repérés
									$count = $req_donneescours->rowCount();

								?>
								<!-- Particularisation du titre de la boîte pour y rappeller la requête ($_POST['requete']), le nombre de résultats obtenus ($count) et la date -->
								<div class="panel-heading">
									<p><strong>Résultats de la requête <samp><?php echo @$_POST['requete'];?></samp> / <?php echo ($count==1?"1 résultat":($count==0?"Aucun résultat":$count." résultats"));?> (en date du <?php echo date('j-m-Y H:i:s');?>)</strong></p>
								</div>
								<div class='panel-body'>
								<?php
									// Boucle pour parcourir la table des résultats
									while ($donnees = $req_donneescours->fetch()) {

										echo "<h3>".$donnees['titre_c']."</h3>";
										echo "<p><strong>Sigle :</strong> ".$donnees['sigle']."</p>";
										echo "<p><strong>Cycle :</strong> ".$donnees['cycles']." cycle</p>";
										echo "<p><strong>Trimestre :</strong> ".$donnees['trimestres']." ".$donnees['annee']."</p>";
										echo "<p><strong>Mode d'enseignement :</strong> ".$donnees['modes']."</p>";
										echo "<dt>Description :</dt><dd>".$donnees['descr']."</dd>";
										echo "<br/>";
										echo "<h4>Autres modalités</h4>";
										echo "<table><tr><th>Statut</th><th>Programme</th><th>Enseignant(e)</th><th>Nombre d'inscriptions</th></tr><tr><td>".$donnees['statuts']."</td><td>".$donnees['titre_p']."</td><td>".$donnees['prenom']." ".$donnees['nom']."</td><td>".$donnees['nbre_et']."</td></table>";

									}

									// Fermeture de la requête et de la base de données
									$req_donneescours->closeCursor();
									$bdd=null;

								}

								// Gestion des erreurs
								catch(Exception $e) {
									die('Erreur : '.$e->getMessage());
								}

							}
						?>
						</div>

					</div>

				</div>

			</div>
        
        </div>
        
        <!-- Pied de page fixe -->
        <?php include '../footer.htm';?>

	</body>

</html>
