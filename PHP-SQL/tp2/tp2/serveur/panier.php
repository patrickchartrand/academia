<?php include('../inc/header.inc.php'); ?>


<?php
	// AJOUT D'UN PRODUIT DANS LE PANIER
	if (isset($_POST['product'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare les variables
		$id_prod = $_POST['product'];
		$quantity = $_POST['cart'];
		$user = $_SESSION['id'];

		// on procède à la requête
		$req = $connect->prepare("INSERT INTO shoppingCarts (userID, filmID, title, quantity, price, image) SELECT '$user', id, title, '$quantity', '$quantity'*price as price, image FROM films WHERE id='$id_prod'");
		$req->execute();

		// on ferme la requête
		$req->closeCursor();
		$connect=null;

		$message = "<div class='alert alert-success' role='alert'>Le produit a été ajouté à votre panier.</div>";
	}

	// RETIRER UN FILM DANS LE PANIER
	if (isset($_POST['delete'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare la variable
		$ref = $_POST['delete'];
		$user = $_SESSION['id'];

		// on procède à la requête
		$req = $connect->prepare("DELETE FROM shoppingCarts WHERE filmID='$ref' AND userID='$user'");
		$req->execute();

		// on ferme la requête
		$req->closeCursor();
		$connect=null;
	}

	// ANNULATION D'UN PANIER D'ACHAT
	if (isset($_POST['cancel'])) {
		// on ouvre la base de données
		include('../donnees/connexion.inc.php');

		// on déclare la variable
		$ref = $_POST['cancel'];

		// on procède à la requête
		$req = $connect->prepare("DELETE FROM shoppingCarts WHERE userID='$ref'");
		$req->execute();

		// on ferme la requête
		$req->closeCursor();
		$connect=null;
	}

	$text = "<section class='jumbotron text-left'>";
	$text .= "<div class='container'>";
	$text .= $message;
	$text .= "<div class='form-row'>";
	$text .= "<div class='col justify-content-start'>";
	$text .= "<p>Bonjour <strong>".$_SESSION['name']."</strong>,<br/>Votre panier d'achats :</p>";
	$text .= "<table class='table' style='text-align:center;'>";
	$text .= "<thead>";
	$text .= "<tr class='table-light'>";
	$text .= "<th>Couverture</th><th>Titre</th><th>Quantité totale</th><th>Prix</th><th></th>";
	$text .= "</tr>";
	$text .= "</thead>";
	$text .= "<tbody>";

	// on ouvre la base de données
	include('../donnees/connexion.inc.php');

	// on déclare la variable
	$user = $_SESSION['id'];

	// on procède à la requête
	$req = $connect->prepare("SELECT *, SUM(quantity) as 'total', SUM(price) as 'addition' FROM shoppingCarts WHERE userID=? GROUP BY title");
	$req->execute(array($user));

	// on récupère les données
	while ($data = $req->fetch()) {

	 	$text .= "<tr class='table-light'>";
		$text .= "<form method='post' action='#' accept-charset='utf-8'>";
		$text .= "<td><img width='150' height='200' src='../images/".$data['image']."'/></td>";
		$text .= "<td>".$data['title']."</td>";
		$text .= "<td>".$data['total']."</td>";
		$text .= "<td>".$data['addition']."$</td>";
		$text .= "<td><button type='submit' class='btn btn-sm btn-outline-danger' name='delete' value='".$data['filmID']."'>Retirer le titre</button></td>";
		$text .= "</tr>";
		$text .= "</form>";

	}

	$text .= "</tbody>";
	$text .= "</table>";
	$text .= "<form method='post' action='#'>";
	$text .= "<button type='submit' class='btn btn-sm btn-outline-danger' name='cancel' value='".$user."'>Vider le panier</button>";
	$text .= "</form>";
	$text .= "</table></div></div></div></section>";

	echo $text;

	// on ferme la requête
	$req->closeCursor();
	$connect=null;
?>


<?php include('../inc/footer.inc.php'); ?>
