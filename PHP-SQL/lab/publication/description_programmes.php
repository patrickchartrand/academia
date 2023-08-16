<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Description Programme</title>
		<meta name="author" content="Christine Dufour" />
		<meta name="description" content="Interface permettant de générer la liste des cours obligatoires et optionnels pour un programme choisi" />
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
										<li class="small"><a href="#">Description Programmes</a></li>
										<li class="small"><a href="description_cours.php">Description Cours</a></li>
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

					<h2>Description Programme</h2>

					<form class="form-horizontal" method="post">

					<!-- Barre de navigation horizontale - menu déroulant -->
					<nav class="navbar navbar-inverse">

						<div class="container-fluid">

							<!-- Construction de la liste déroulante des programmes présents dans la base de données pour lesquels il y a des cohortes -->
							<!-- L'événement ONCHANGE permet de soumettre le formulaire afin d'adapter la liste déroulante des années au choix de programme -->

							<select class="form-control navbar-btn boite_recherche" name="programme_choix" id="programme_choix" onChange="submit();">

								<option value="" >Programme</option>
								<option value="" disabled>- - - - - - - - - - - - - - - - - </option>

								<?php

									try
										{
											// Ouverture de la base de données
											include '../App_Data/ouverture_bd.php';

											// Définition de la requête pour aller chercher la liste des programmes
											// existants ayant des cohortes
											$req_listeprogs = $bdd->prepare('SELECT DISTINCT prog2.cycle, prog2.version, prog2.annee_p, prog2.titre_p FROM prog2, coho2 WHERE prog2.version=coho2.version AND prog2.cycle=coho2.cycle ORDER BY prog2.cycle, prog2.version;');

											// Exécution de la requête
											$req_listeprogs->execute();

											// Boucle pour parcourir la table des résultats
											while ($donnees = $req_listeprogs->fetch())
											{
												// Affichage de la balise option pour un programme
												echo '<option value="'.$donnees['cycle'].'-'.$donnees['version'].'-'.$donnees['annee_p'].' '.$donnees['titre_p'].'"'.'>'.$donnees['cycle'].'-'.$donnees['version'].'-'.$donnees['annee_p'].' '.$donnees['titre_p'].'</option>';

											}

											// Fermeture de la requête et de la base de données
											$req_listeprogs->closeCursor();
											$bdd=null;
										}

									// Gestion des erreurs
									catch(Exception $e)
									{
									die('Erreur : '.$e->getMessage());
									}
								?>

							</select>


						</div>

					</nav>

					</form>

					<!-- Zone pour l'affichage des résultats -->

					<div id="resultats_programmes" class="panel panel-default">
						<div class="panel-heading"><strong>Structure pour le programme <?php echo @$_POST['programme_choix'];?></strong> (en date du <?php echo date("j-m-Y H:i:s");?>)</div>
						<div class="panel-body">

						<?php

						// Condition pour vérifier si un choix de programme a été fait
						if (@$_POST['programme_choix'])
						{

							// Affichage des cours obligatoires
							try
							{
								// Ouverture de la base de données
								include '../App_Data/ouverture_bd.php';

								//Division du programme choisi en version et cycle
								$no_programme=explode("-",$_POST['programme_choix']);

								// Définition de la requête pour aller chercher la liste des programmes
								// existants ayant des cohortes
								$req_donneesprog = $bdd->prepare('select concat(prog2.cycle, "-", prog2.version, "-", annee_p, " ", titre_p) as "nom_prog", cours2.sigle, cours2.titre_c, cours2.descr, offre2.statut from prog2, offre2, cours2 where prog2.version=offre2.version AND prog2.cycle=offre2.cycle AND offre2.sigle=cours2.sigle AND prog2.cycle=:cycle AND prog2.version=:version AND offre2.statut="ob" order by prog2.cycle,prog2.version,offre2.statut, cours2.sigle;');

								// Exécution de la requête
								$req_donneesprog->execute(array('version'=>$no_programme[1],'cycle'=>$no_programme[0]));

								$count = $req_donneesprog->rowCount();

								echo "<h3>Cours obligatoires (".$count.")</h3>";

								// Boucle pour parcourir la table des résultats
								while ($donnees = $req_donneesprog->fetch())
								{

									?>
									<dl>
									<dt><?php echo $donnees['sigle']." ".$donnees['titre_c'];?></dt>
									<dd><?php echo $donnees['descr'];?></dd>
									</dl>
									<?php

								}

								// Fermeture de la requête et de la base de données
								$req_donneesprog->closeCursor();
								$bdd=null;
							}

							// Gestion des erreurs
							catch(Exception $e)
							{
							die('Erreur : '.$e->getMessage());
							}

							// Affichage des cours optionnels

							try
							{
								// Ouverture de la base de données
								include '../App_Data/ouverture_bd.php';

								//Division du programme choisi en version et cycle
								$no_programme=explode("-",$_POST['programme_choix']);

								// Définition de la requête pour aller chercher la liste des programmes
								// existants ayant des cohortes
								$req_donneesprog = $bdd->prepare('select concat(prog2.cycle, "-", prog2.version, "-", annee_p, " ", titre_p) as "nom_prog", cours2.sigle, cours2.titre_c, cours2.descr, offre2.statut from prog2, offre2, cours2 where prog2.version=offre2.version AND prog2.cycle=offre2.cycle AND offre2.sigle=cours2.sigle AND prog2.cycle=:cycle AND prog2.version=:version AND offre2.statut="op" order by prog2.cycle,prog2.version,offre2.statut, cours2.sigle;');

								// Exécution de la requête
								$req_donneesprog->execute(array('version'=>$no_programme[1],'cycle'=>$no_programme[0]));

								$count = $req_donneesprog->rowCount();

								echo "<h3>Cours à option (".$count.")</h3>";

								// Boucle pour parcourir la table des résultats
								while ($donnees = $req_donneesprog->fetch())
								{

									?>
									<dl>
									<dt><?php echo $donnees['sigle']." ".$donnees['titre_c'];?></dt>
									<dd><?php echo $donnees['descr'];?></dd>
									</dl>
									<?php

								}



								// Fermeture de la requête et de la base de données
								$req_donneesprog->closeCursor();
								$bdd=null;
							}

							// Gestion des erreurs
							catch(Exception $e)
							{
							die('Erreur : '.$e->getMessage());
							}
						}
						else
						{ echo "Veuillez choisir un programme dans le menu déroulant ci-dessus."; }

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
