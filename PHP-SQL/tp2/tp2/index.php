<?php session_start(); ?>
<?php
  // DÉCONNEXION D'UNE SESSION
  if (isset($_POST['logout'])) {
    // on ouvre la base de données
    include('donnees/connexion.inc.php');

    // on termine la session en cours
    session_unset();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <title>Lab Work #2</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/myStyle.css"/>
  </head>
  <body>

    <header>
      <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container">
          <div class="row justify-content-start">
            <a class="navbar-brand" href="index.php">Accueil</a>
            <form class="form-inline my-2 my-lg-0" method="post" action="serveur/produits.php">
              <input class="form-control text-secondary" type="submit" name="films" value="Nos films"/>
              <select class="form-control text-secondary" name="genres" onchange="this.form.submit();">
                <option selected>Genres</option>
                <?php
                  // on ouvre la base de données
                  include('donnees/connexion.inc.php');

                  // on procède à la requête
                  $req = $connect->prepare("SELECT genre FROM films GROUP BY genre ORDER BY genre ASC");
                  $req->execute();

                  // on récupère les données
                  while ($data = $req->fetch()) {

                    echo "<option value='".$data['genre']."'>".$data['genre']."</option>";

                  }

                  // on ferme la requête
                  $req->closeCursor();
                  $connect=null;
                ?>
              </select>
            </form>
          </div>
          <div class="row justify-content-end">
          <?php
            if (isset($_SESSION['admin'])) {
                echo "<a class='nav-link text-white' href='serveur/administration.php'><svg class='bi bi-wrench' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z'/></svg>&nbsp;&nbsp;Édition du site Web</a>";
                echo "<form method='post' action='#'><button type='submit' class='btn btn-outline-light' name='logout'>Déconnexion</button></form>";
            } else if (isset($_SESSION['name'])) {
              echo "<a class='nav-link text-white' href='serveur/panier.php'><svg class='bi bi-bag' width='1em' height='1em' viewBox='0 0 16 16' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z'/><path d='M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z'/></svg>&nbsp;&nbsp;Mon panier</a>";
              echo "<form method='post' action='#'><button type='submit' class='btn btn-outline-light' name='logout'>Déconnexion</button></form>";
            } else if (isset($_SESSION['id']) == false) :
          ?>
            <form class="form-inline my-2 my-lg-0" method="post" action="serveur/membres.php">
              <button type="submit" class="btn btn-outline-light" name="inscription">Devenir membre</button>
              <button type="submit" class="btn btn-outline-secondary" name="connection">Connexion</button>
            </form>
            <?php endif ?>
          </div>
        </div>
      </nav>
    </header>

    <main role="main">
      <section class="jumbotron text-center">
        <div class="container">
          <h1>Cinémathèque</h1>
          <p class="lead text-muted">Revisionnez les grands classiques du cinéma hollywoodien des 90's</p>
        </div>
      </section>
      <div class="container">
        <div id="carousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carousel" data-slide-to="0" class="active"></li>
            <li data-target="#carousel" data-slide-to="1"></li>
            <li data-target="#carousel" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img class="d-block w-100" src="https://cdn.pixabay.com/photo/2017/11/24/10/43/admission-2974645_960_720.jpg" alt="première image">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="https://cdn.pixabay.com/photo/2017/11/24/10/43/analogue-2974647_960_720.jpg" alt="seconde image">
            </div>
            <div class="carousel-item">
              <img class="d-block w-100" src="https://cdn.pixabay.com/photo/2014/04/27/22/44/chicago-333599_960_720.jpg" alt="troisième image">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Back to top</a>
        </p>
        <p>Par Patrick Chartrand</p>
      </div>
    </footer>

    <!-- JavaScript for Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
