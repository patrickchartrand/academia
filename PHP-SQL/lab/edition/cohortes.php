<?php

	// Ensemble des actions à effectuer en fonction du bouton utilisé

	// Mise en mémoire du point d'entrée (nouvel accès); si choix fait de programme et/ou année, mise en mémoire des choix
	if (@$_POST['programme_choix']<>"")
		{$programme=$_POST['programme_choix'];}
	else
		{$programme="";}

		if (@$_POST['annee_choix']<>"")
		{$annee_c=$_POST['annee_choix'];}
	else
		{$annee_c="";}


	//*----------------------------------------------------
	//* Enregistrer une cohorte (mise à jour)
	//*----------------------------------------------------

	if (@$_POST['action']=="Enregistrer")
	{

		try
			{
				// Ouverture de la base de données
				include '../App_Data/ouverture_bd.php';


				// Requête pour la mise à jour d'un enregistrement existant
				$req_enregistrementcohorte = $bdd->prepare('UPDATE coho2 SET nbre_dem=:nbre_dem, ad_tplein=:ad_tplein, ad_tpartiel=:ad_tpartiel, notes_coh=:notes_coh WHERE annee_c=:annee_c AND version=:version AND cycle=:cycle;');

				// Division du choix de programme pour récupérer la version et le cycle
				$no_programme = explode("-", $_POST['programme_choix']);

				//Exécution de la requête en fonction des valeurs saisies dans les champs.
				//Pour les champs facultatifs, interception des valeurs vides pour mettre des NULL
				$req_enregistrementcohorte->execute(array('version' => $no_programme[1], 'cycle' => $no_programme[0], 'annee_c' => $_POST['annee_choix'], 'nbre_dem' => ($_POST['nbre_dem']<>""?$_POST['nbre_dem']:Null), 'ad_tplein' => ($_POST['ad_tplein']<>""?$_POST['ad_tplein']:Null), 'ad_tpartiel' => ($_POST['ad_tpartiel']<>""?$_POST['ad_tpartiel']:Null), 'notes_coh' => ($_POST['notes_coh']<>""?$_POST['notes_coh']:Null)));

				// Fermeture de la requête et de la base de données
				$req_enregistrementcohorte->closeCursor();

			}

			// Gestion des erreurs
			catch(Exception $e)
			{
			die('Erreur : '.$e->getMessage());
			}

	}

	//*----------------------------------------------------
	//* Effacer une cohorte existante
	//*----------------------------------------------------

	if (@$_POST['action']=="Supprimer")
	{
		try
		{
			// Ouverture de la base de données
			include '../App_Data/ouverture_bd.php';

			// Division du choix de programme pour récupérer la version et le cycle
			$no_programme = explode("-", $programme);


			// Requête pour supprimer la cohorte sélectionnée
			$req_suppcohorte = $bdd->prepare('DELETE FROM coho2 WHERE annee_c=:annee_c AND version=:version AND cycle=:cycle;');

			// Exécution de la requête et définition de la variable utilisée
			$req_suppcohorte->execute(array('annee_c' => $_POST['annee_choix'], 'version' => $no_programme[1], 'cycle' =>$no_programme[0]));

			// Fermeture de la requête et de la base de données
			$req_suppcohorte->closeCursor();
			$bdd=null;

			// Remise à zéro de la variable année
			$annee_c="";
		}

		//Gestion des erreurs
		catch(Exception $e)
		{
		die('Erreur : '.$e->getMessage());
		}
	}

	//Remise en mémoire des valeurs des contrôles pour les afficher dans les contrôles du formulaire des données s'il s'agit d'un enregistrement ou de la modification d'une cohorte.

	if ($annee_c>0)
	{

		try
			{
				// Ouverture de la base de données
				include '../App_Data/ouverture_bd.php';

				// Requête pour récupérer l'information sur la cohorte sélectionnée

				// Division du choix de programme pour récupérer la version et le cycle
				$no_programme = explode("-", $programme);

				$req_infocohorte = $bdd->prepare('SELECT version, cycle, annee_c, nbre_dem, ad_tplein, ad_tpartiel, notes_coh FROM coho2 WHERE annee_c=:annee_choix AND version=:version AND cycle=:cycle;');

				// Exécution de la requête et définition des variables utilisées
				$req_infocohorte->execute(array('annee_choix' => $annee_c, 'version' => $no_programme[1], 'cycle' => $no_programme[0]));

				// Dénombrement du nombre d'enregistrement trouvé
				$count = $req_infocohorte->rowCount();

				// Si aucun enregistrement, aucune année choisie pour le programme, donc extraction pour ce programme de sa première année
				if ($count==0)
				{
					$req_infocohorte = $bdd->prepare('SELECT version, cycle, annee_c, nbre_dem, ad_tplein, ad_tpartiel, notes_coh FROM coho2 WHERE version=:version AND cycle=:cycle order by annee_c limit 1;');

					// Exécution de la requête et définition de la variable utilisée
					$req_infocohorte->execute(array('version' => $no_programme[1], 'cycle' => $no_programme[0]));
				}


				// Boucle pour parcourir les enregistrements de la table de données correspondant aux résultats de la requête
				while ($donnees = $req_infocohorte->fetch())
				{
					// Mise en mémoire des données dans des variables pour les afficher dans le formulaire
					$version = $donnees['version'];
					$cycle = $donnees['cycle'];
					$annee_c = $donnees['annee_c'];
					$nbre_dem = $donnees['nbre_dem'];
					$ad_tplein = $donnees['ad_tplein'];
					$ad_tpartiel = $donnees['ad_tpartiel'];
					$notes_coh = $donnees['notes_coh'];
				}

				// Fermeture de la requête et de la base de données
				$req_infocohorte->closeCursor();
				$bdd=null;
			}

			// Gestion des erreurs
			catch(Exception $e)
			{
			die('Erreur : '.$e->getMessage());
			}
	}

?><!DOCTYPE html>
<html lang="fr">

	<head>
		<title>Modification des informations sur les cohortes</title>
		<meta name="author" content="Christine Dufour" />
		<meta name="description" content="Interface pour la mise à jour des données sur les cohortes" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../css/bootstrap.min.css" />
		<link rel="icon" type="image/ico" href="../images/favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>

		<!-- Inclusion d'une feuille de styles personnalisée -->
		<?php include '../css/css_modifications.txt' ?>

		<script>

		// Pour l'activation de la fonctionnalité Tooltips de Bootstrap
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});

		// Fonction pour valider la suppression
		function validation() {
			return confirm("Voulez-vous vraiment supprimer cette cohorte?");
		}

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
										<li class="small"><a href="programmes.php">Programmes</a></li>
										<li class="small"><a href="cours.php">Cours</a></li>
										<li class="small"><a href="enseignants.php">Enseignants</a></li>
										<li class="small"><a href="#">Cohortes</a></li>
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

					<h2>Modification des informations sur les cohortes</h2>

					<!-- FORMULAIRE À L'HORIZONTAL -->
					<form class="form-horizontal" id="formulaire_cohortes" name="formulaire_cohortes" method="post" action="cohortes.php">

						<!-- Barre de navigation horizontale -->
						<nav class="navbar navbar-inverse">

							<div class="container-fluid">

								<!-- Construction de la liste déroulante des programmes présents dans la base de données pour lesquels il y a des cohortes -->
								<!-- L'événement ONCHANGE permet de soumettre le formulaire afin d'adapter la liste déroulante des années au choix de programme -->

								<select class="form-control navbar-btn" style="width:500px;display:inline;" name="programme_choix" id="programme_choix" onChange="submit();">

									<option value=""  <?php if ($programme=="") {echo "selected";}?> disabled>Programme</option>
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
													// Affichage de la balise option pour un stage
													echo "<option value='".$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p']."'".($programme==$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p']?" selected":"").">".$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p']." ".$donnees['titre_p']."</option>";

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

								<!-- Construction de la liste déroulante des années des cohortes pour le programme retenu -->
								<!-- L'événement ONCHANGE soumet le formulaire pour afficher les données de l'année choisie -->
								<select class="form-control navbar-btn" style="width:200px;" name="annee_choix" id="annee_choix" onChange="submit();">

									<option value=""  <?php if ($annee_c=="") {echo "selected";}?> disabled> Année</option>
									<option value="" disabled>- - - - - - - - - - - - - - - - - </option>

									<?php

										try
											{
												// Ouverture de la base de données
												include '../App_Data/ouverture_bd.php';

												// Division du programme pour retrouver la version et le cycle
												$no_programme = explode("-", $programme);

												// Définition de la requête pour aller chercher la liste des années
												// existantes
												$req_listeannees = $bdd->prepare('SELECT cycle, version, annee_c FROM coho2 WHERE cycle='.(@$no_programme[0]?@$no_programme[0]:1).' AND version='.(@$no_programme[1]?@$no_programme[1]:1).' ORDER BY annee_c;');

												// Exécution de la requête
												$req_listeannees->execute();

												// Boucle pour parcourir la table des résultats
												while ($donnees = $req_listeannees->fetch())
												{
													// Affichage de la balise option pour un stage
													echo "<option value='".$donnees['annee_c']."'".($annee_c==$donnees['annee_c']?" selected":"").">".$donnees['annee_c']."-".($donnees['annee_c']+1)."</option>";

												}

												// Fermeture de la requête et de la base de données
												$req_listeannees->closeCursor();
												$bdd=null;
											}

										// Gestion des erreurs
										catch(Exception $e)
										{
										die('Erreur : '.$e->getMessage());
										}
									?>

								</select>




								<!-- Boutons pour l'enregistrement et la suppression -->
								<input class="btn btn-success navbar-btn" name="action" id="Enregistrer" type="submit" value="Enregistrer" />

								<!-- L'événement ONCHANGE appelle la fonction de validation pour s'assurer de bien vouloir supprimer -->
								<input class="btn btn-danger navbar-btn" name="action" type="submit" value="Supprimer" onClick="return validation();" <?php echo ($annee_c>0?'':'disabled="disabled"');?> />

							</div>

						</nav>



						<div id="edition_cohorte" class="panel panel-default">

							<div class="panel-heading"><strong>Information sur la cohorte<?php echo (@$programme?" du programme ".$programme.(@$annee_c?" pour l'année universitaire ".$annee_c."-".($annee_c+1):""):"");?></strong></div>
						<div class="panel-body">

							<!-- NBRE_DEM -->
							<div class="form-group">

								<!-- Étiquette devant le contrôle -->
								<label class="control-label col-sm-3">Nombre total de demandes d'admission</label>

								<!-- Contrôle pour la saisie -->
								<!-- Contrôle désactivé (disabled) si aucune année choisie -->
								<div class="col-sm-9">
									<input class="form-control" name="nbre_dem" id="nbre_dem" type="number" max="999" oninput="nbadmission();" value="<?php echo (@$nbre_dem<>""?$nbre_dem:"");?>" <?php echo ($annee_c>0?'':'disabled="disabled"');?> />
								</div>
							</div>

							<!-- NB TEMPS PLEIN -->
							<div class="form-group">

								<!-- Étiquette devant le contrôle -->
								<label class="control-label col-sm-3">Nombre d'admissions à temps plein</label>

								<!-- Contrôle pour la saisie -->
								<div class="col-sm-9">
									<input class="form-control" name="ad_tplein" id="ad_tplein" type="number" max="999" value="<?php echo (@$ad_tplein<>""?$ad_tplein:"");?>" <?php echo ($annee_c>0?'':'disabled="disabled"');?> />
								</div>
							</div>

							<!-- NB TEMPS PARTIEL -->
							<div class="form-group">

								<!-- Étiquette devant le contrôle -->
								<label class="control-label col-sm-3">Nombre d'admissions à temps partiel</label>

								<!-- Contrôle pour la saisie -->
								<!-- Contrôle en lecture seule (readonly) comme la valeur est déduite -->
								<div class="col-sm-9">
									<input class="form-control" name="ad_tpartiel" id="ad_tpartiel" type="number" max="999" value="<?php echo (@$ad_tpartiel<>""?$ad_tpartiel:"");?>" <?php echo ($annee_c>0?'':'disabled="disabled"');?> />
								</div>
							</div>

							<!-- NOTES_COH -->
							<div class="form-group">

								<!-- Étiquette devant le contrôle -->
								<label class="control-label col-sm-3">Notes</label>

								<!-- Contrôle pour la saisie -->
								<div class="col-sm-9">
									<textarea class="form-control" name="notes_coh" id="notes_coh" cols="120" rows="5" maxlength="1000" <?php echo ($annee_c>0?'':'disabled="disabled"');?>><?php echo (@$notes_coh?$notes_coh:Null);?></textarea>
								</div>
							</div>

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
