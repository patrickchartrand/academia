<?php include('../inc/header.inc.php'); ?>


<?php
	// AJOUT D'UN FILM DANS LA BASE DE DONNÉES
	if (isset($_POST['addition'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare les variables
		$title = htmlentities($_POST['add_title'], ENT_QUOTES);
		$producer = $_POST['add_producer'];
		$genre = $_POST['add_genre'];
		$duration = $_POST['add_duration'];
		$quantity = $_POST['add_quantity'];
		$price = $_POST['add_price'];
		$image = $_POST['add_image'];
		$video = $_POST['add_video'];
		@move_uploaded_file($FILES['add_image']['tmp_name']);
		@move_uploaded_file($FILES['add_video']['tmp_name']);

		// on procède à la requête
		$req = $connect->prepare("INSERT INTO films (title, producer, genre, duration, quantity, price, image, video) VALUES ('$title', '$producer', '$genre', '$duration', '$quantity', '$price', '$image', '$video')");
		$req->execute();

		// on ferme la requête
		$req->closeCursor();
		$connect=null;
	}

	// MODIFICATION DES INFOS D'UN FILM DANS LA BASE DE DONNÉES
	if (isset($_POST['modification'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare les variable
		$ref = $_POST['modification'];
		$title = $_POST['new_title'];
		$producer = $_POST['new_producer'];
		$genre = $_POST['new_genre'];
		$duration = $_POST['new_duration'];
		$quantity = $_POST['new_quantity'];
		$price = $_POST['new_price'];

		// on procède à la requête
		$req = $connect->prepare("UPDATE films SET title=?, producer=?, genre=?, duration=?, quantity=?, price=? WHERE id=?");
		$req->execute(array($title,$producer,$genre,$duration,$quantity,$price,$ref));

		// on ferme la requête
		$req->closeCursor();
		$connect=null;
	}

	// MODIFICATION DE L'IMAGE D'UN FILM DANS LA BASE DE DONNÉES
	if (isset($_POST['change_image'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare les variable
		$ref = $_POST['change_image'];
		$image = $_POST['new_image'];
		@move_uploaded_file($FILES['new_image']['tmp_name']);

		// on procède à la requête
		$req = $connect->prepare("UPDATE films SET image=? WHERE id=?");
		$req->execute(array($image,$ref));

		// on ferme la requête
		$req->closeCursor();
		$connect=null;
	}

	// MODIFICATION DE LA VIDÉO D'UN FILM DANS LA BASE DE DONNÉES
	if (isset($_POST['change_video'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare les variable
		$ref = $_POST['change_video'];
		$video = $_POST['new_video'];
		@move_uploaded_file($FILES['new_video']['tmp_name']);

		// on procède à la requête
		$req = $connect->prepare("UPDATE films SET video=? WHERE id=?");
		$req->execute(array($video,$ref));

		// on ferme la requête
		$req->closeCursor();
		$connect=null;
	}

	// SUPPRESSION D'UN FILM DANS LA BASE DE DONNÉES
	if (isset($_POST['suppression'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare la variable
		$ref = $_POST['suppression'];

		// on procède à la requête
		$req = $connect->prepare("DELETE FROM films WHERE id=$ref");
		$req->execute();

		// on ferme la requête
		$req->closeCursor();
		$connect=null;
	}

	if (isset($_SESSION['admin'])) {

		$text = "<section class='jumbotron text-left'>";
		$text .= "<div class='form-row'>";
		$text .= "<div class='col justify-content-start'>";
		$text .= "<p class='lead text-muted'><b>Gestion des contenus</b></p>";
		$text .= "<p class='lead text-muted'>Publier un nouveau film :</p>";
		// tableau d'ajout
		$text .= "<table class='table'>";
		/*$text .= "<thead>";
		$text .= "<tr class='table-light' style='text-align:center;'>";
		$text .= "<th>Multimédias</th><th colspan='2'>Informations générales</th><th>Options</th>";
		$text .= "</tr>";
		$text .= "</thead>";*/
		$text .= "<tbody>";
		$text .= "<tr class='table-light'>";
		$text .= "<form method='post' action='#'>";
		$text .= "<td class='align-middle' style='text-align:center;'><label for='add_image'>Image :</label><br/><input type='file' id='add_image' name='add_image' required/><br/><hr><label for='add_video'>Vidéo :</label><br/><input type='file' id='add_video' name='add_video' required/></td>";
		$text .= "<td><label for='add_title'>Titre :</label><br/><input type='text' id='add_title' name='add_title' required/><br/><br/><label for='add_producer'>Producteur :</label><br/><input type='text' id='add_producer' name='add_producer' required/><br/><br/><label for='add_genre'>Genre :</label><br/><input type='text' id='add_genre' name='add_genre' required/></td>";
		$text .= "<td><label for='add_duration'>Durée :</label><br/><input type='number' name='add_duration' required/><br/><br/><label for='add_quantity'>Quantité disponible :</label><br/><input type='number' id='add_quantity' name='add_quantity' required/><br/><br/><label for='add_price'>Prix :</label><br/><input type='number' id='add_price' name='add_price' required/></td>";
		$text .= "<td class='align-middle' style='text-align:center;'><button type='submit' class='btn btn-sm btn-outline-success' name='addition'>Ajouter</button></td>";
		$text .= "</form>";
		$text .= "</tr>";
		$text .= "</tbody></table>";
		// tableau de modification et de suppression
		$text .= "<p class='lead text-muted'>Éditer un film :</p>";
		$text .= "<table class='table table-light table-hover'>";
		/*$text .= "<thead>";
		$text .= "<tr class='table-light' style='text-align:center;'>";
		$text .= "<th>Multimédias</th><th colspan='3'>Informations générales</th><th>Options</th>";
		$text .= "</tr>";
		$text .= "</thead>";*/
		$text .= "</body>";

		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on procède à la requête
		$req = $connect->prepare("SELECT * FROM films ORDER BY id DESC");
		$req->execute();

		// on récupère les données
		while ($data = $req->fetch()) {

			$text .= "<tr class='table-light'>";
			$text .= "<form method='post' action='#'>";
			$text .= "<td style='text-align:center;'>";
			$text .= "<label for='new_image'>Image :</label><br/><input type='file' id='new_image' name='new_image'/><br/><br/><button type='submit' class='btn btn-sm btn-outline-success' name='change_image' value='".$data['id']."'>Changer l'image</button><br/><hr>";
			$text .= "</form>";
			$text .= "<form method='post' action='#'>";
			$text .= "<label for='add_video'>Vidéo :</label><br/><input type='file' id='new_video' name='new_video'/><br/><br/><button type='submit' class='btn btn-sm btn-outline-success' name='change_video' value='".$data['id']."'>Changer la vidéo</button>";
			$text .= "</form>";
			$text .= "</td>";
			$text .= "<td class='align-middle'><img width='150' height='200' src='../images/".$data['image']."'/></td>";
			$text .= "<form method='post' action='#'>";
			$text .= "<td class='align-middle'><label for='new_title'>Titre :</label><br/><input type='text' id='new_title' name='new_title' value='".html_entity_decode($data['title'])."'/><br/><br/><label for='new_producer'>Producteur :</label><br/><input type='text' id='new_producer' name='new_producer' value='".$data['producer']."'/><br/><br/><label for='new_genre'>Genre :</label><br/><input type='text' id='new_genre' name='new_genre' value='".$data['genre']."'/></td>";
			$text .= "<td class='align-middle'><label for='new_duration'>Durée :</label><br/><input type='number' id='new_duration' name='new_duration' value='".$data['duration']."'/><br/><br/><label for='new_quantity'>Quantité disponible :</label><br/><input type='number' id='new_quantity' name='new_quantity' value='".$data['quantity']."'/><br/><br/><label for='new_price'>Prix :</label><br/><input type='number' id='new_price' name='new_price' value='".$data['price']."'/></td>";
			$text .= "<td class='align-middle' style='text-align:center;'><button type='submit' class='btn btn-sm btn-outline-success' name='modification' value='".$data['id']."'>Modifier</button><br/><br/><button type='submit' class='btn btn-sm btn-outline-danger' name='suppression' value='".$data['id']."'>Supprimer</button></td>";
			$text .= "</form>";
			$text .= "</tr>";

		}

		$text .= "</tbody></table></div></div></section>";
		echo $text;

		// on ferme la requête
		$req->closeCursor();
		$connect=null;
	}
?>


<?php include('../inc/footer.inc.php'); ?>
