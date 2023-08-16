<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>École des Sciences de l'Information Essentielle</title>
		<meta name="author" content="Christine Dufour" />
		<meta name="description" content="Tableau de bord de l'Ecole des Sciences de l'Information Essentielle pour la gestion de programme" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="icon" type="image/ico" href="images/favicon.ico" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

		<?php include 'css/css_modifications.txt' ?>

	</head>

	<body>

		<div class="container-fluid">
			<header class="row navbar-fixed-top">
				<div class="container-fluid">
				<!-- Nous avons changé le titre de la page - suiprog étant peu convivial - et y avons ajouté un lien permettant de revenir à la page d'accueil peu importe la page sur laquelle on est-->
					<h1>École des Sciences de l'Information Essentielle</h1>
				</div>
			</header>
			<div class="row content">
				<div class="col-sm-3 sidenav">
					<nav class="navbar navbar-default">
						<div class="navbar-header">
						  <img class="img-thumbnail" src="images/information.jpg" alt="stages" />
						</div>
						<div style="width:93%;margin:auto;">
							<ul class="nav navbar-nav">
								<li class="small dropdown">
									<a class="dropdow-toggle" data-toggle="dropdown" href="#">Module Édition<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li class="small"><a href="edition/programmes.php">Programmes</a></li>
										<li class="small"><a href="edition/cours.php">Cours</a></li>
										<li class="small"><a href="edition/enseignants.php">Enseignants</a></li>
										<li class="small"><a href="edition/cohortes.php">Cohortes</a></li>
									</ul>
								</li>
								<li class="small dropdown">
									<a class="dropdow-toggle" data-toggle="dropdown" href="#">Module Visualisation<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li class="small"><a href="publication/bilan.php">Bilan ESCIE</a></li>
										<li class="small"><a href="publication/description_programmes.php">Description Programmes</a></li>
										<li class="small"><a href="publication/description_cours.php">Description Cours</a></li>
										<li class="small"><a href="publication/recherche_enseignants.php">Recherche Enseignants</a></li>
										<li class="small"><a href="publication/recherche_cours.php">Recherche Cours</a></li>
									</ul>
								</li>
							</ul>
						</div>
					</nav>
				</div>

				<div class="col-sm-9">

					<h2>Accueil</h2>

					<p>Bienvenue dans l'environnement Web du tableau de bord pour le suivi des programmes de l'École des Sciences de l'Information Essentielle (ESCIE). Cet environnement possède deux modules : (1) un module d'édition et (2) un module de visualisation.</p>

				</div>
			</div>

			<?php include 'footer.htm';?>

		</div>
	</body>
</html>
