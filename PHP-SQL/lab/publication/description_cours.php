<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Description Cours</title>
		<meta name="author" content="Patrick Chartrand" />
		<meta name="description" content="Interface permettant de générer la description d'un cours sélectionné dans une liste" />
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
			/* Le bloc de style perso comprennant deux paragraphes dont le second a de l'information facultative sur le premier */
			#mystyle p {
				display: inline-block;
			}
			/* L'option d'information facultative est indiquée par le soulignement */
			#mystyle span {
				text-decoration: underline;
				text-decoration-style: dotted;
			}
			/* Le second paragraphe pour afficher des indications sur le premier est caché et donc affiché seulement si c'est nécessaire */
			#mystyle p:last-child  {
				visibility: hidden;
				font-size: 10px;
				margin-left: 10px;
			}
			/* Si le curseur est glissé sur le paragraphe en question, l'information facultative est affichée */
			#mystyle:hover p:last-child, #mystyle:hover span {
				visibility: visible;
				text-decoration: none;
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
										<li class="small"><a href="#">Description Cours</a></li>
										<li class="small"><a href="recherche_enseignants.php">Recherche Enseignants</a></li>
										<li class="small"><a href="recherche_cours.php">Recherche Cours</a></li>
									</ul>
								</li>
							</ul>

						</div>

					</nav>

				</div>

				<!-- Corps de la page -->
				<div class="col-sm-9">

					<h2>Description Cours</h2>

					<form class="form-horizontal" method="post">

					<!-- Barre de navigation horizontale - menu déroulant -->
					<nav class="navbar navbar-inverse">

						<div class="container-fluid">

							<!-- Construction de la liste déroulante des cours présents dans la base de données pour lesquels il y a un lien à un enseignant et à un programme -->
							<!-- L'événement ONCHANGE permet de soumettre le formulaire afin d'adapter la liste déroulante des années au choix de programme -->

							<select class="form-control navbar-btn boite_recherche" name="cours_choix" id="cours_choix" onChange="submit();">

								<option value="" >Cours</option>
								<option value="" disabled>- - - - - - - - - - - - - - - - - </option>

								<?php
									// Affichage des cours
									try {

										// Ouverture de la base de données
										include '../App_Data/ouverture_bd.php';

										// Définition de la requête pour aller chercher la liste des cours
										$req_listecours = $bdd->prepare('SELECT DISTINCT cours2.sigle, cours2.titre_c FROM cours2 ORDER BY cours2.sigle ASC;');

										// Exécution de la requête
										$req_listecours->execute();

										// Boucle pour parcourir la table des résultats
										while ($donnees = $req_listecours->fetch()) {

											// Affichage de la balise option pour un cours
											echo '<option value="'.$donnees['sigle'].' - '.$donnees['titre_c'].'"'.'>'.$donnees['sigle'].' - '.$donnees['titre_c'].'</option>';

										}

										// Fermeture de la requête et de la base de données
										$req_listecours->closeCursor();
										$bdd=null;

										}

									// Gestion des erreurs
									catch(Exception $e) {
										die('Erreur : '.$e->getMessage());
									}
								?>

							</select>


						</div>

					</nav>

					</form>

					<!-- Zone pour l'affichage des résultats -->

					<div id="resultats_cours" class="panel panel-default">
						<div class="panel-heading"><strong>Informations pour le cours <?php echo @$_POST['cours_choix'];?></strong> (en date du <?php echo date("j-m-Y H:i:s");?>)</div>
						<div class="panel-body">

						<?php
							// Condition pour vérifier si un choix de programme a été fait
							if (@$_POST['cours_choix']) {

								// Affichage des informations du cours
								try {

									// Ouverture de la base de données
									include '../App_Data/ouverture_bd.php';

									// Division du cours choisi en sigle et titre
									$no_cours=explode(" - ",$_POST['cours_choix']);

									// Définition de la requête pour aller chercher les informations au cours
									$req_donneescours = $bdd->prepare('SELECT cours2.sigle, cours2.titre_c, cours2.descr, min(donne2.annee),max(donne2.annee) FROM cours2, donne2 WHERE cours2.sigle=donne2.sigle AND cours2.sigle=:sigle AND cours2.titre_c=:titre_c;');

									// Exécution de la requête
									$req_donneescours->execute(array('titre_c'=>$no_cours[1],'sigle'=>$no_cours[0]));

									// Parcours de la table des résultats
									$donnees = $req_donneescours->fetch();

									// Affichage des informations sur le cours
									echo "<h3>".$donnees['titre_c']."</h3>";
									echo "<p><strong>Sigle : </strong>".$donnees['sigle']."</p>";
									echo "<div id='mystyle'><p><strong><span>Période</span> : </strong>".$donnees['min(donne2.annee)']." à ".$donnees['max(donne2.annee)']."<p>Période durant laquelle le cours a été offert.</p>
									</div>";
									echo "<dt><dt>Description du cours :<dt><dd>".$donnees['descr']."</dd></dt>";

									// Fermeture de la requête et de la base de données
									$req_donneescours->closeCursor();
									$bdd=null;

								}

								// Gestion des erreurs
								catch(Exception $e) {
									die('Erreur : '.$e->getMessage());
								}

								// Début de la sous-zone d'affichage sur l'historique par cours (enseignants et programmes reliés)
								echo "<br/>";
								echo "<h4>Historique du cours</h4>";

								// Affichage des enseignants reliés au cours
								try {

									// Ouverture de la base de données
									include '../App_Data/ouverture_bd.php';

									// Division du programme choisi en sigle et titre
									$no_cours=explode(" - ",$_POST['cours_choix']);

									// Définition de la requête pour aller chercher les informations reliées au cours
									$req_donneescours = $bdd->prepare('SELECT ensg2.prenom, ensg2.nom FROM cours2, donne2 INNER JOIN ensg2 ON donne2.matr=ensg2.matr WHERE cours2.sigle=donne2.sigle AND cours2.sigle=:sigle AND cours2.titre_c=:titre_c GROUP BY donne2.matr;');

									// Exécution de la requête
									$req_donneescours->execute(array('titre_c'=>$no_cours[1],'sigle'=>$no_cours[0]));

									echo "<p><strong>Liste des enseignants par lesquels il a été offert :</strong></p>";

									// Boucle pour parcourir la table des résultats
									while ($donnees = $req_donneescours->fetch()) {

										// Affichage de la liste informant sur le cours : enseignants et leurs années en charge
										echo "<ul><li>".$donnees['prenom']." ".$donnees['nom']."</li></ul>";

									}

									// Fermeture de la requête et de la base de données
									$req_donneescours->closeCursor();
									$bdd=null;

								}

								// Gestion des erreurs
								catch(Exception $e) {
									die('Erreur : '.$e->getMessage());
								}

								// Affichage des programmes reliés au cours
								try {

									// Ouverture de la base de données
									include '../App_Data/ouverture_bd.php';

									// Division du cours choisi en sigle et titre
									$no_cours=explode(" - ",$_POST['cours_choix']);

									// Définition de la requête pour aller chercher les informations reliées au cours
									$req_donneescours = $bdd->prepare('SELECT prog2.titre_p FROM cours2, offre2 INNER JOIN prog2 ON offre2.cycle=prog2.cycle AND offre2.version=prog2.version WHERE cours2.sigle=offre2.sigle AND cours2.sigle=:sigle AND cours2.titre_c=:titre_c GROUP BY offre2.version, offre2.cycle ORDER BY prog2.annee_p ASC;');

									// Exécution de la requête
									$req_donneescours->execute(array('titre_c'=>$no_cours[1],'sigle'=>$no_cours[0]));

									echo "<p><strong>Liste des programmes auxquels il a été ou est associé :</strong></p>";

									// Boucle pour parcourir la table des résultats
									while ($donnees = $req_donneescours->fetch()) {

										// Affichage de la liste informant sur le cours : programmes et leur année
										echo "<ul><li>".$donnees['titre_p']."</li></ul>";

									}

									// Fermeture de la requête et de la base de données
									$req_donneescours->closeCursor();
									$bdd=null;
								}

								// Gestion des erreurs
								catch(Exception $e) {
									die('Erreur : '.$e->getMessage());
								}

							} else {

								echo "Veuillez choisir un programme dans le menu déroulant ci-dessus.";

							}
						?>

						</div>

					</div>

				</div>

			</div>

			<!-- Pied de page fixe -->
			<?php include '../footer.htm';?>

		</div>
	</body>

</html>
