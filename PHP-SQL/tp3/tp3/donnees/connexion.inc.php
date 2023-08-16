<?php
  $dns = "mysql:host=www-ens.iro.umontreal.ca;dbname=chartrpa_bdfilms";
  $opt = [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ];
  try {
      $connexion = new PDO($dns, "chartrpa", "rpap108C", $opt);
      $connexion->exec("SET CHARACTER SET utf8");
  } catch (Exception $e) {
      error_log($e->getMessage());
      exit("une erreur s'est produite");
  }
?>
