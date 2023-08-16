<?php include('../inc/header.inc.php'); ?>
<?php include('../inc/main.inc.php'); ?>


<?php
  // AFFICHAGE DE TOUS LES PRODUITS
  if (isset($_POST['films'])) {
    // on ouvre la base de données
    include('../donnees/connexion.inc.php');

    // on procède à la requête
    $req = $connect->prepare("SELECT * FROM films ORDER BY title ASC");
    $req->execute();
  }

  // AFFICHAGE DES PRODUITS PAR CATÉGORIE
  if (isset($_POST['genres']) && !isset($_POST['films'])) {
    // on ouvre la base de données
    include('../donnees/connexion.inc.php');

    // on déclare la variable
    $ref = $_POST['genres'];

    // on procède à la requête
    $req = $connect->prepare("SELECT * FROM films WHERE genre=? ORDER BY title ASC");
    $req->execute(array($ref));

    // on fait un fil d'Ariane
    $fil = "<div class='container'>";
    $fil .= "<p class='float-left text-muted'><i>Recherche par catégorie > ".$ref."</i></p>";
    $fil .= "</div>";
  }

  $text = $fil;
  $text .= "<div class='album py-5'>";
  $text .= "<div class='container'>";
  $text .= "<div class='row'>";

  // on récupère les données
  while ($data = $req->fetch()) {

    $text .= "<div class='col-md-4'>";
    $text .= "<div class='card mb-4 box-shadow'>";
    $text .= "<a class='link-img' data-toggle='modal' data-target='#".$data['id']."'><img class='bd-placeholder-img' width='100%' height='500' src='../images/".$data['image']."'/></a>";
    $text .= "<div class='card-body'>";
    $text .= "<p class='card-text'><b>".$data['title']."</b><br/>".$data['producer']."<br/>".$data['price']."$</p>";
    $text .= "<div class='d-flex justify-content-between align-items-center'>";
    $text .= "<small class='text-muted'>".$data['duration']." minutes</small>";

    // on propose d'acheter si c'est un membre
    if (isset($_SESSION['name'])) {
      $text .= "<form method='post' action='panier.php'>";
      $text .= "<div class='form-group'>";
      $text .= "<select class='form-control' name='cart' style='width:5em;'>";
      for ($i = 1; $i <= $data['quantity']; $i++) {
        $text .= "<option value='".$i."'>".$i."</option>";
      }
      $text .= "</select>";
      $text .= "</div>";
      $text .= "<button type='submit' class='btn btn-sm btn-outline-primary' name='product' value='".$data['id']."'>Acheter</button>";
      $text .= "</form>";
    }
    $text .= "</div></div></div></div>";

    // on fait un effet « modal »
    $text .= "<div class='modal fade' id='".$data['id']."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
    $text .= "<div class='modal-dialog' role='document'>";
    $text .= "<div class='modal-content'>";
    $text .= "<div class='modal-header'>";
    $text .= "<h2 class='modal-title'>".$data['title']."</h2>";
    $text .= "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    $text .= "<span aria-hidden='true'>&times;</span>";
    $text .= "</button></div>";
    $text .= "<div class='modal-body'>";
    $text .= "<video width='100%' controls>";
    $text .= "<source src='../videos/".$data['video']."' type='video/mp4'>";
    $text .= "</video>";
    $text .= "</div>";
    $text .= "<div class='modal-footer'>";
    $text .= "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fermer</button>";
    $text .= "</div></div></div></div>";

  }

  $text .= "</div></div></div>";
  echo $text;

  // on ferme la requête
  $req->closeCursor();
  $connect=null;
?>


<?php include('../inc/footer.inc.php'); ?>
