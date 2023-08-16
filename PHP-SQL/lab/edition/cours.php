<?php

	// Ensemble des actions à effectuer en fonction du bouton utilisé

	// Mise en mémoire du point d'entrée (nouvel accès ou nouveau cours : $sigle_choix=""; autre (modification ou
	// suppression) : sigle cours choisi dans la liste déroulante
	if (@$_POST['sigle_choix']<>"")
		{$sigle=$_POST['sigle_choix'];}
	else
		{$sigle="SIE";}

	//*----------------------------------------------------
	//* Enregistrer un cours (nouveau ou mise à jour)
	//*----------------------------------------------------

	if (@$_POST['action']=="Enregistrer")
	{

		// Vérification de l'existance du sigle (pour éviter des doublons)
		try
			{
				$validationsigle=0;

				// Ouverture de la base de données
				include '../App_Data/ouverture_bd.php';

				// Recherche du sigle
				$req_verificationsigle = $bdd->prepare('SELECT COUNT(*) as validation FROM cours2 WHERE sigle="'.$_POST['sigle'].'";');

				$req_verificationsigle->execute();

				while ($donnees = $req_verificationsigle->fetch())
				{
					$validationsigle=$donnees['validation'];
				}
				// Fermeture de la requête et de la base de données
				$req_verificationsigle->closeCursor();
				$bdd=null;

			}

			// Gestion des erreurs
			catch(Exception $e)
			{
			die('Erreur : '.$e->getMessage());
			}


		if (@$validationsigle==0 || $sigle<>"SIE") // Si le sigle n'existe pas déjà ou mise à jour

		{

		try
			{
				// Ouverture de la base de données
				include '../App_Data/ouverture_bd.php';

				// Définition de la requête SQL selon la valeur de $sigle (si <>"", mise à jour; si = "", ajout)
				if ($sigle<>"SIE")
				{
					// Requête s'il s'agit de la mise à jour d'un enregistrement existant
					//$req_enregistrementcours = $bdd->prepare('UPDATE cours2 SET titre_c=:titre_c, descr=:descr, notes_c=:notes_c WHERE sigle="'.$sigle.'";');
					$req_enregistrementcours = $bdd->prepare('UPDATE cours2 SET titre_c=:titre_c, descr=:descr, notes_c=:notes_c WHERE sigle=:sigle;');

					//Exécution de la requête en fonction des valeurs saisies dans les champs.
					$req_enregistrementcours->execute(array('sigle' => $sigle, 'titre_c' => $_POST['titre_c'], 'descr' => $_POST['descr'], 'notes_c' => $_POST['notes_c']));

				}
				else
				{
					// Requête s'il s'agit d'un nouvel enregistrement
					$req_enregistrementcours = $bdd->prepare('INSERT INTO cours2 (sigle, titre_c, descr, notes_c) VALUES (:sigle, :titre_c, :descr, :notes_c);');

					//Exécution de la requête en fonction des valeurs saisies dans les champs.
					$req_enregistrementcours->execute(array('sigle' => $_POST['sigle'], 'titre_c' => $_POST['titre_c'], 'descr' => $_POST['descr'], 'notes_c' => $_POST['notes_c']));


				}

				//Exécution de la requête en fonction des valeurs saisies dans les champs.
				//$req_enregistrementcours->execute(array('sigle' => $_POST['sigle'], 'titre_c' => $_POST['titre_c'], 'descr' => $_POST['descr'], 'notes_c' => $_POST['notes_c']));

				// Fermeture de la requête et de la base de données
				$req_enregistrementcours->closeCursor();

			}

			// Gestion des erreurs
			catch(Exception $e)
			{
			die('Erreur : '.$e->getMessage());
			}

			// Enregistrement des informations sur les programmes associés

			//Validation programme par programme


			try
		{
			// Ouverture de la base de données
			include '../App_Data/ouverture_bd.php';

			// Définition de la requête pour aller chercher la liste des cours
			// existants
			$req_listeprogs = $bdd->prepare('SELECT prog2.cycle, prog2.version, prog2.annee_p FROM prog2;');

			// Exécution de la requête
			$req_listeprogs->execute();

			// Boucle pour parcourir la table des résultats
			while ($donnees = $req_listeprogs->fetch())
			{

				// Vérification si programme dans offre2 pour cours

				try
				{

					// Définition de la requête pour aller chercher la liste des cours
					// existants
					$req_validationbd = $bdd->prepare('SELECT offre2.cycle FROM offre2 WHERE offre2.cycle=:cycle AND offre2.version=:version AND offre2.sigle=:sigle;');

					// Exécution de la requête
					$req_validationbd->execute(array('cycle' => $donnees['cycle'], 'version' => $donnees['version'], 'sigle' => (@$_POST['sigle']?$_POST['sigle']:$sigle)));

					$count = $req_validationbd->rowCount();

					if ($count==0)
						{

							$case = "chkpg".$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];
							$statut = "statut".$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];
							$notes = "notes".$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];

							if (@$_POST[$case]=="on")
							{

							$req_prog_traitement= $bdd->prepare('INSERT INTO offre2 (cycle, version, sigle, statut, notes_o) VALUES ('.$donnees['cycle'].', '.$donnees['version'].', "'.(@$_POST['sigle']?$_POST['sigle']:$sigle).'", "'.$_POST[$statut].'", '.(strlen($_POST[$notes])==0?'NULL':'"'.$_POST[$notes].'"').');');

							$req_prog_traitement->execute();

							}


						}
						else
						{

							$case = "chkpg".$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];
							$statut = "statut".$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];
							$notes = "notes".$donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];

							if (@$_POST[$case]=="on")
							{

							$req_prog_traitement= $bdd->prepare('UPDATE offre2 SET statut="'.$_POST[$statut].'", notes_o='.(strlen($_POST[$notes])==0?'NULL':'"'.$_POST[$notes].'"').' WHERE offre2.cycle='.$donnees['cycle'].' AND offre2.version='.$donnees['version'].' AND offre2.sigle= "'.(@$_POST['sigle']?$_POST['sigle']:$sigle).'";');

							$req_prog_traitement->execute();

							}

							else
							{

							$req_prog_traitement= $bdd->prepare('DELETE FROM offre2 WHERE offre2.cycle='.$donnees['cycle'].' AND offre2.version='.$donnees['version'].' AND offre2.sigle= "'.(@$_POST['sigle']?$_POST['sigle']:$sigle).'";');

							$req_prog_traitement->execute();

							}

						}



					// Fermeture de la requête
					$req_validationbd->closeCursor();

					}

					// Gestion des erreurs
					catch(Exception $e)
					{
					die('Erreur : '.$e->getMessage());
					}

			// Exécution de la requête


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



			$erreur_sigle=0;
		}
		else
		{
			// Mise en mémoire des données dans des variables pour les ré-afficher dans le formulaire
			$sigle = 'SIE';
			$titre_c = $_POST['titre_c'];
			$descr = $_POST['descr'];
			$notes_c = $_POST['notes_c'];

			//Mise à jour des variables servant à afficher ou non les messages d'erreur dans le formulaire
			$erreur_sigle=1;
		}

	}

	//*----------------------------------------------------
	//* Effacer un cours existant
	//*----------------------------------------------------

	if (@$_POST['action']=="Supprimer")
	{
		try
		{
			// Ouverture de la base de données
			include '../App_Data/ouverture_bd.php';

			// Requête pour supprimer le stage sélectionné
			$req_suppcours = $bdd->prepare('DELETE FROM cours2 WHERE cours2.sigle=:sigle;');

			// Exécution de la requête et définition de la variable utilisée
			$req_suppcours->execute(array('sigle' => (@$_POST['sigle']?$_POST['sigle']:$sigle)));

			// Fermeture de la requête et de la base de données
			$req_suppcours->closeCursor();
			$bdd=null;

			// Remise à zéro de la variable sigle
			$sigle="";
		}

		//Gestion des erreurs
		catch(Exception $e)
		{
		die('Erreur : '.$e->getMessage());
		}
	}

	//Remise en mémoire pour les afficher dans les contrôles du formulaire des données s'il s'agit d'un enregistrement ou de l'ajout d'un stage.

	if ($sigle<>"")
	{

		try
			{
				// Ouverture de la base de données
				include '../App_Data/ouverture_bd.php';

				// Requête pour récupérer l'information sur le stage sélectionné
				$req_infocours = $bdd->prepare('SELECT cours2.sigle, cours2.titre_c, cours2.descr, cours2.notes_c FROM cours2 WHERE cours2.sigle=:sigle_choix;');

				// Exécution de la requête et définition de la variable utilisée
				$req_infocours->execute(array('sigle_choix' => $sigle));

				// Boucle pour parcourir les enregistrements de la table de données correspondant aux résultats de la requête
				while ($donnees = $req_infocours->fetch())
				{
					// Mise en mémoire des données dans des variables pour les afficher dans le formulaire
					$sigle = $donnees['sigle'];
					$titre_c = $donnees['titre_c'];
					$descr = $donnees['descr'];
					$notes_c = $donnees['notes_c'];
				}

				// Fermeture de la requête et de la base de données
				$req_infocours->closeCursor();
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
		<title>Saisie des informations sur les cours</title>
		<meta name="author" content="Christine Dufour" />
		<meta name="description" content="Formulaire pour l'ajout ou la modification des cours" />
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

		// Pour générer les fonctions qui permettront de cacher ou montrer les champs à saisir pour les programmes associés
		$(function () {
		<?php
		try
		{
			// Ouverture de la base de données
			include '../App_Data/ouverture_bd.php';

			// Définition de la requête pour aller chercher la liste des cours
			// existants
			$req_listeprogs = $bdd->prepare('SELECT prog2.cycle, prog2.version, prog2.annee_p FROM prog2;');

			// Exécution de la requête
			$req_listeprogs->execute();

			// Boucle pour parcourir la table des résultats
			while ($donnees = $req_listeprogs->fetch())
			{
				?>


					$("#chkpg<?php echo $donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];?>").click(function () {
						if ($(this).is(":checked")) {
							$("#dvpg<?php echo $donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];?>").show();
						} else {
							$("#dvpg<?php echo $donnees['cycle']."-".$donnees['version']."-".$donnees['annee_p'];?>").hide();
						}
					});


				<?php

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
    });

		// Fonction pour valider la suppression
		function validation() {
			return confirm("Voulez-vous vraiment supprimer ce cours?");
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
										<li class="small"><a href="#">Cours</a></li>
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

					<h2>Saisie des informations sur les cours</h2>

					<!-- FORMULAIRE À L'HORIZONTAL -->
					<form class="form-horizontal" id="formulaire_cours" name="formulaire_cours" method="post" action="cours.php">

						<!-- Barre de navigation horizontale -->
						<nav class="navbar navbar-inverse">

							<div class="container-fluid">

								<!-- Construction de la liste déroulante des cours présents dans la base de données, en ordre alphabétique de sigle -->

								<select class="form-control navbar-btn" name="sigle_choix" id="sigle_choix" onChange="submit();">

									<option value=""  <?php if ($sigle=="") {echo "selected";}?> disabled>Cours à éditer</option>
									<option value="" disabled>- - - - - - - - - - - - - - - - - </option>
									<option value="SIE">Nouveau cours</option>
									<option value="" disabled>- - - - - - - - - - - - - - - - - </option>

									<?php

										try
											{
												// Ouverture de la base de données
												include '../App_Data/ouverture_bd.php';

												// Définition de la requête pour aller chercher la liste des cours
												// existants
												$req_listecours = $bdd->prepare('SELECT cours2.sigle, cours2.titre_c FROM cours2 ORDER BY cours2.sigle;');

												// Exécution de la requête
												$req_listecours->execute();

												// Boucle pour parcourir la table des résultats
												while ($donnees = $req_listecours->fetch())
												{
													// Affichage de la balise option pour un stage
													echo "<option value='".$donnees['sigle']."'".($sigle==$donnees['sigle']?" selected":"").">".$donnees['sigle']." ".$donnees['titre_c']."</option>";

												}

												// Fermeture de la requête et de la base de données
												$req_listecours->closeCursor();
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
								<input class="btn btn-danger navbar-btn" name="action" type="submit" value="Supprimer" onClick="return validation();" <?php echo ($sigle<>"" && $sigle<>"SIE"?'':'disabled="disabled"');?> />

							</div>

						</nav>

						<div id="edition_cours" class="panel panel-default">


						<div class="panel-heading"><strong>Information sur les cours</strong></div>
						<div class="panel-body">

							<!-- SIGLE -->
							<div class="form-group">

								<!-- Étiquette devant le contrôle -->
								<label data-toggle="tooltip" data-placement="bottom" class="control-label col-sm-3 obligatoire" title="Sigle en format SIE000.">Sigle</label>

								<!-- Contrôle pour la saisie -->
								<div class="col-sm-9">
									<input class="form-control" name="sigle" id="sigle" type="text" maxlength="6" required pattern="SIE[0-9][0-9][0-9]" value="<?php echo (@$sigle<>""?$sigle:"SIE");?>" <?php echo (@$erreur_sigle==1?' style="color:red"':'');?> <?php echo ($sigle<>"SIE"?"disabled":"");?> />
									<span style="color:red;display:<?php echo (@$erreur_sigle==1?'inline':'none');?>">Sigle déjà utilisé</span>
								</div>
							</div>

							<!-- TITRE -->
							<div class="form-group">

								<!-- Étiquette devant le contrôle -->
								<label class="control-label col-sm-3 obligatoire">Titre</label>

								<!-- Contrôle pour la saisie -->
								<div class="col-sm-9">
									<input class="form-control" type="text" name="titre_c" id="titre_c" maxlength="130" required value="<?php echo (@$titre_c?$titre_c:"");?>" />
								</div>
							</div>

							<!-- DESCR -->
							<div class="form-group">

								<!-- Étiquette devant le contrôle -->
								<label class="control-label col-sm-3 obligatoire">Description</label>

								<!-- Contrôle pour la saisie -->
								<div class="col-sm-9">
									<textarea class="form-control" name="descr" id="descr" required cols="120" rows="3" maxlength="250"><?php echo (@$descr?$descr:"");?></textarea>
								</div>
							</div>

							<!-- NOTES_C -->
							<div class="form-group">

								<!-- Étiquette devant le contrôle -->
								<label class="control-label col-sm-3">Notes</label>

								<!-- Contrôle pour la saisie -->
								<div class="col-sm-9">
									<textarea class="form-control" name="notes_c" id="notes_c" cols="120" rows="5" maxlength="1000"><?php echo (@$notes_c?$notes_c:Null);?></textarea>
								</div>
							</div>
							</div>
						</div>

						<div id="edition_programme" class="panel panel-default">
						<div class="panel-heading"><strong>Information sur le(s) programme(s) associé(s)</strong></div>
						<div class="panel-body">

						<?php

						try
							{
								// Ouverture de la base de données
								include '../App_Data/ouverture_bd.php';

								// Définition de la requête pour aller chercher la liste des programmes
								// existants
								$req_listeprogs = $bdd->prepare('SELECT prog2.cycle as cyclep, prog2.version as versionp, prog2.annee_p as anneep, prog2.titre_p as titrep, prog_associe.statut, prog_associe.notes_o
FROM prog2 left join (SELECT prog2.titre_p, prog2.version, prog2.cycle, prog2.annee_p, offre2.statut, offre2.notes_o FROM prog2, offre2 WHERE prog2.version=offre2.version AND prog2.cycle=offre2.cycle AND offre2.sigle="'.$sigle.'") as prog_associe ON prog2.cycle=prog_associe.cycle AND prog2.version=prog_associe.version ORDER BY prog2.cycle, prog2.version;');

								// Exécution de la requête
								$req_listeprogs->execute();

								echo '<table class="table table-hover"><tr><th>Programme</th><th>Statut & Notes</th></tr>';

								// Boucle pour parcourir la table des résultats
								while ($donnees = $req_listeprogs->fetch())
								{
									$no_programme = $donnees['cyclep'].'-'.$donnees['versionp'].'-'.$donnees['anneep'];

									// Affichage de la balise
									echo "<tr><td>";

									echo '<label class="checkbox-inline" for="chkpg'.$no_programme.'"><input name="chkpg'.$no_programme.'" id="chkpg'.$no_programme.'" type="checkbox"'.($donnees['statut']<>""?"checked":"").' />'.$no_programme." ".$donnees['titrep'].'</label></td><td><div class="form-inline" id="dvpg'.$no_programme.'"'.($donnees['statut']==""?" style='display:none;'":"").">";

									echo '<div class="form-group">';
									?>

											<select class="form-control" id="statut<?php echo $no_programme;?>" name="statut<?php echo $no_programme;?>">
												<option  value="OB" <?php echo ($donnees['statut']=='OB'?'selected="selected"':"");?>>Obligatoire</option>
												<option  value="OP" <?php echo ($donnees['statut']=='OP'?'selected="selected"':"");?>>Optionnel</option>
											</select>

									<?php
									echo '<textarea class="form-control" cols="100" rows="1" id="notes'.$no_programme.'" name="notes'.$no_programme.'">'.$donnees['notes_o'].'</textarea>'."</div></div></td></tr>";
								}

								echo '</table>';

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
