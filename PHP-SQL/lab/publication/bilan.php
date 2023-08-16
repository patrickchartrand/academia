<!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Bilan de l'ESCIE</title>
		<meta name="author" content="Andréanne Boisjoli" />
		<meta name="description" content="Bialn des activités de l'ESCI" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="icon" type="image/ico" href="../images/favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<!-- Inclusion d'une feuille de styles personnalisée -->
		<?php  include '../css/css_modifications.txt' ?>

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
										<li class="small"><a href="#">Bilan ESCIE</a></li>
										<li class="small"><a href="description_programmes.php">Description Programmes</a></li>
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

					<h2>Bilan de l'ESCIE</h2>


<!-- premier tableau sur les cycles-->

				<div id="resultats_cycles" class="panel panel-default">
					<div class="panel-heading"><strong>Information sur les différents cycles</strong> (en date du <?php echo date("j-m-Y H:i:s");?>)</div>
					<div class="panel-body">

					<?php

												try
												{
													// Ouverture de la base de données
													include '../App_Data/ouverture_bd.php';

													// Définition de la requête pour aller chercher les informations sur les cycles
													$req_donneescycle = $bdd->prepare('SELECT prog2.cycle as cycle, min(prog2.annee_p) as depuis, max(DISTINCT prog2.annee_p) as dernier, COUNT(DISTINCT prog2.annee_p) as combien_versions, COUNT(DISTINCT offre2.sigle) as combien_cours
													FROM prog2
													INNER JOIN offre2 ON prog2.cycle=offre2.cycle
													GROUP BY prog2.cycle');
													// exécution de la requête;
												$req_donneescycle->execute();

												// présentation des résultats de la requête sous forme de tableau
											echo "<div class='table-responsive'>
											<table class='table'>

									 <tr>
									 		<th>Cycle</th>
										 <th>Ce cycle propose des programmes depuis</th>
										 <th>La dernière version a été lancée en</th>
										 <th>Nombre de versions depuis les débuts</th>
										 <th>Nombre de cours offerts dans ce cycle</th>
									 </tr>";

												 // Boucle pour parcourir la table des résultats
												 while ($donnees = $req_donneescycle->fetch())
												 {

												 ?>

												<tr>
													<td><?php echo $donnees['cycle'];?></td>
													<td><?php echo $donnees['depuis'];?></td>
													<td><?php echo $donnees['dernier'];?></td>
													<td><?php echo $donnees['combien_versions'];?></td>
													<td><?php echo $donnees['combien_cours'];?></td>
												</tr>
												<?php
												 }
												echo  "</table></div>";





												 // Fermeture de la requête et de la base de données
												 $req_donneescycle->closeCursor();
												 $bdd=null;
											 }


											 // Gestion des erreurs
											 catch(Exception $e)
											 {
											 die('Erreur : '.$e->getMessage());
											 }




											?>

											</div>

											</div>




<!-- deuxième tableau sur les charges d'enseignement-->

															<div id="resultats_charges" class="panel panel-default">
																<div class="panel-heading"><strong>Bilan des charges d'enseignement</strong> (en date du <?php echo date("j-m-Y H:i:s");?>)</div>
																<div class="panel-body">

																<?php

																							try
																							{
																								// Ouverture de la base de données
																								include '../App_Data/ouverture_bd.php';

																								// Définition de la requête pour aller chercher les informations sur les charges d'enseignement
																								$req_donneescharge = $bdd->prepare("SELECT CONCAT((case when donne2.trimestre='A' then 'Automne' WHEN donne2.trimestre='H' THEN 'Hiver' WHEN donne2.trimestre='E' THEN 'Été' ELSE null END), ' ' , donne2.annee) as antri, (SELECT COUNT( DISTINCT donne2.matr) from donne2 where profil='c' and concat((case when donne2.trimestre='A' then 'Automne' WHEN donne2.trimestre='H' THEN 'Hiver' WHEN donne2.trimestre='E' THEN 'Été' ELSE null END), ' ' , donne2.annee)=antri) AS 'cours_charge', (SELECT COUNT( DISTINCT donne2.matr) from donne2 where profil='p' and concat((case when donne2.trimestre='A' then 'Automne' WHEN donne2.trimestre='H' THEN 'Hiver' WHEN donne2.trimestre='E' THEN 'Été' ELSE null END), ' ' , donne2.annee)=antri) AS 'cours_prof', count(distinct donne2.sigle) as 'cours_ cycle' FROM donne2 GROUP BY antri ORDER by donne2.annee ASC, donne2.trimestre DESC");





																								// exécution de la requête;
																							$req_donneescharge->execute();

																							// présentation des résultats de la requête sous forme de tableau
																						echo "<div class='table-responsive'>
																						<table class='table'>

																				 <tr>
																				 		<th>Trimestre / année</th>
																					 <th>Chargés de cours <br>donnant un cours</th>
																					 <th>Professeurs <br>donnant un cours</th>
																					 <th>Cours donnés par cycle</th>

																				 </tr>";

																							 // Boucle pour parcourir la table des résultats
																							 while ($donnees = $req_donneescharge->fetch())
																							 {

																							 ?>

																							<tr>
																									<td><?php echo $donnees['antri'];?></td>
																								<td><?php echo $donnees['cours_charge'];?></td>
																								<td><?php echo $donnees['cours_prof'];?></td>
																								<td><?php echo $donnees['cours_ cycle'];?></td>

																							</tr>
																							<?php
																							 }
																							echo  "</table></div>";





																							 // Fermeture de la requête et de la base de données
																							 $req_donneescharge->closeCursor();
																							 $bdd=null;
																						 }


																						 // Gestion des erreurs
																						 catch(Exception $e)
																						 {
																						 die('Erreur : '.$e->getMessage());
																						 }




																						?>

																						</div>

																						</div>

																						</div>

																						</div>

			<!-- Pied de page fixe -->
			<?php include '../footer.htm ';?>

		</div>
	</body>

</html>
