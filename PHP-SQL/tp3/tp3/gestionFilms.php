<?php
  include("donnees/connexion.inc.php");
  $tab=array();

  /******************************************************/
  // fonction d'information sur le traitement
  function informer($info){
    header ("Content-Type: text/xml");
    $txt="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $txt.="<information>\n";
      $txt.="<info>\n";
        $txt.=$info;
      $txt.="</info>\n";
    $txt.="</information>\n";
    echo $txt;
  }
  /******************************************************/

  // fonction pour ajouter
  function ajouter(){
    global $connexion,$tab;
    $title=$_POST['title'];
    $producer=$_POST['producer'];
    $genre=$_POST['genre'];
    $duration=$_POST['duration'];
    $price=$_POST['price'];
    $quantity=$_POST['quantity'];
    $image=$_POST['image'];
    $video=$_POST['video'];
    $requete="INSERT INTO films VALUES (0,?,?,?,?,?,?,?,?)";
    $stmt=$connexion->prepare($requete);
    $stmt->execute(array($title,$producer,$genre,$duration,$price,$quantity,$image,$video));
    informer("Le film #".$connexion->lastInsertId()." a bien été ajouté !\n");
  }

  // fonction pour afficher
  function afficher(){
    global $connexion, $tab;
    $req="SELECT * FROM films ORDER BY id DESC";
    try{
      $stmt=$connexion->prepare($req);
      $stmt->execute();
      header ("Content-Type: text/xml");
      $txt="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
      $txt.="<films>\n";
      while ($line = $stmt->fetch(PDO::FETCH_ASSOC)){
        $txt.="<film>\n";
        $txt.="<id>".$line['id']."</id>\n";
        $txt.="<title>".$line['title']."</title>\n";
        $txt.="<producer>".$line['producer']."</producer>\n";
        $txt.="<genre>".$line['genre']."</genre>\n";
        $txt.="<duration>".$line['duration']."</duration>\n";
        $txt.="<price>".$line['price']."</price>\n";
        $txt.="<quantity>".$line['quantity']."</quantity>\n";
        $txt.="<image>".$line['image']."</image>\n";
        $txt.="<video>".$line['video']."</video>\n";
        $txt.="</film>\n";
      }
      $txt.="</films>\n";
      echo $txt;
    } catch (Exception $e){
      
    }
  }

  // fonction pour classer les genres
  function classer(){
    global $connexion, $tab;
    $req="SELECT * FROM films GROUP BY genre ORDER BY genre";
    try{
      $stmt=$connexion->prepare($req);
      $stmt->execute();
      header ("Content-Type: text/xml");
      $txt="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
      $txt.="<films>\n";
      while ($line = $stmt->fetch(PDO::FETCH_ASSOC)){
        $txt.="<film>\n";
        $txt.="<id>".$line['id']."</id>\n";
        $txt.="<title>".$line['title']."</title>\n";
        $txt.="<producer>".$line['producer']."</producer>\n";
        $txt.="<genre>".$line['genre']."</genre>\n";
        $txt.="<duration>".$line['duration']."</duration>\n";
        $txt.="<price>".$line['price']."</price>\n";
        $txt.="<quantity>".$line['quantity']."</quantity>\n";
        $txt.="<image>".$line['image']."</image>\n";
        $txt.="<video>".$line['video']."</video>\n";
        $txt.="</film>\n";
      }
      $txt.="</films>\n";
      echo $txt;
    } catch (Exception $e){
      
    }
  }

  // fonction pour rechercher un genre
  function rechercher(){
    global $connexion, $tab;
    $ref=$_POST['genres'];
    $req="SELECT * FROM films WHERE genre=?";
    try{
      $stmt=$connexion->prepare($req);
      $stmt->execute(array($ref));
      header ("Content-Type: text/xml");
      $txt="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
      $txt.="<films>\n";
      while ($line = $stmt->fetch(PDO::FETCH_ASSOC)){
        $txt.="<film>\n";
        $txt.="<id>".$line['id']."</id>\n";
        $txt.="<title>".$line['title']."</title>\n";
        $txt.="<producer>".$line['producer']."</producer>\n";
        $txt.="<genre>".$line['genre']."</genre>\n";
        $txt.="<duration>".$line['duration']."</duration>\n";
        $txt.="<price>".$line['price']."</price>\n";
        $txt.="<quantity>".$line['quantity']."</quantity>\n";
        $txt.="<image>".$line['image']."</image>\n";
        $txt.="<video>".$line['video']."</video>\n";
        $txt.="</film>\n";
      }
      $txt.="</films>\n";
      echo $txt;
    } catch (Exception $e){
      
    }
  }

  // contrôleur
  $action=$_POST['action'];
  switch($action){
    case 'ajouter':
      ajouter();
    break;
    case 'afficher':
      afficher();
    break;
    case 'classer':
      classer();
    break;
    case 'rechercher':
      rechercher();
    break;  
  }
?>
