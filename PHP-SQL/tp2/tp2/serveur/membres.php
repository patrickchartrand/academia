<?php include('../inc/header.inc.php'); ?>


<?php
	// INSCRIPTION D'UN MEMBRE
	if (isset($_POST['signin'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare les variables
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$valid_name = 0;
		$valid_email = 0;

		// on procède à la requête
		$req_verif = $connect->prepare("SELECT COUNT(CASE WHEN name LIKE '$name' THEN 1 END) AS valid_name, COUNT(CASE WHEN email LIKE '$email' THEN 1 END) AS valid_email FROM users");
		$req_verif->execute();

		// on récupère les données
		while ($donnees = $req_verif->fetch()) {

			$valid_name = $donnees['valid_name'];
			$valid_email = $donnees['valid_email'];

		}

		// on ferme la requête
		$req_verif->closeCursor();
		$connect=null;

		// on indique si le nom est déjà inscrit
		if ($valid_name > 0) {
			$message = "<div class='alert alert-danger' role='alert'>Le nom d'usager est déjà pris.</div>";

			// on indique si l'adresse courriel est déjà inscrite
		} else if ($valid_email > 0) {
			$message = "<div class='alert alert-danger' role='alert'>L'adresse courriel est déjà prise.</div>";

			// on indique que le membre est inscrit
		} else {
			$message = "<div class='alert alert-success' role='alert'>L'inscription a bien été envoyée ! Vous pouvez maintenant vous connecter.</div>";

			// on ouvre la base de données
			include('../donnees/connexion.inc.php');

			// on prépare la requête
			$req = $connect->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
			$req->execute(array(name => $_POST['name'], email => $_POST['email'], password => $hash));

			// on ferme la requête
			$req->closeCursor();
			$connect=null;
		}
	}

	// CONNEXION D'UN MEMBRE
	if (isset($_POST['login'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare les variables
		$email = $_POST['email'];
		$password = $_POST['password'];
		$validation = 0;

		// on procède à la requête
		$req_verif = $connect->prepare("SELECT *, COUNT(CASE WHEN email LIKE '$email' THEN 1 END) as validation FROM users WHERE email = '$email'");
		$req_verif->execute();

		// on récupère les données
		while ($donnees = $req_verif->fetch()) {

			$validation = $donnees['validation'];
			$hash = $donnees['password'];
			$id_user = $donnees['id'];
			$name_user = $donnees['name'];

		}

		// on ferme la requête
		$req_verif->closeCursor();
		$connect=null;

		// on débute la session d'admin si les informations sont valides
		if ($name_user == 'admin' && password_verify($password, $hash)) {
			$_SESSION['id'] = $id_user;
			$_SESSION['admin'] = $name_user;
			header("Location: administration.php");

			// on débute la session d'usager si les informations sont valides
		} else if ($validation == 1 && password_verify($password, $hash)) {
			$_SESSION['id'] = $id_user;
			$_SESSION['name'] = $name_user;
			header("Location: panier.php");

			// on indique si les informations sont invalides
		} else {
			$message = "<div class='alert alert-danger' role='alert'>L'identifiant ou le mot de passe est invalide.</div>";

		}
	}

	// PRÉSENTATION DU CONTENU DE LA PAGE
	if (isset($_POST['inscription']) || isset($_POST['connection']) || isset($_POST['signin']) || isset($_POST['login'])) {

		$text = "<section class='jumbotron text-left'>";
		$text .= "<div class='container'>";
		$text .= $message;
		$text .= "<div class='form-row'>";
		$text .= "<div class='col justify-content-start'>";
		$text .= "<p><b>Veuillez remplir le formulaire :</b></p>";
		$text .= "<form method='post' action='#'>";
		if (isset($_POST['inscription']) || isset($_POST['signin'])) {
			$text .= "<div class='form-group'>";
			$text .= "<label for='inputNom'>Nom d'usager</label>";
			$text .= "<input type='text' class='form-control' placeholder='Nom' name='name' required/>";
			$text .= "</div>";
		}
		$text .= "<div class='form-group'>";
		$text .= "<label for='inputEmail'>Adresse courriel</label>";
		$text .= "<input type='email' class='form-control' id='inputEmail' aria-describedby='emailHelp' placeholder='Adresse courriel' name='email' required/>";
		$text .= "</div>";
		$text .= "<div class='form-group'>";
		$text .= "<div class='form-group'>";
		$text .= "<label for='inputPassword'>Mot de passe</label>";
		$text .= "<input type='password' class='form-control' id='inputPassword' placeholder='Mot de passe' name='password' required/>";
		$text .= "</div>";
		if (isset($_POST['connection']) || isset($_POST['login'])) {
			$text .= "<button type='submit' class='btn btn-primary' name='login'>Envoyer</button>";
		} else {
			$text .= "<button type='submit' class='btn btn-primary' name='signin'>Envoyer</button>";
		}
		$text .= "</form></div></div></div></section>";
		echo $text;

	}
?>


<?php include('../inc/footer.inc.php'); ?>
