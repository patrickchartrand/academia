var requetesFilms=function(action){
  switch(action){
    case 'ajouter':
      $.ajax({
        url: 'gestionFilms.php',
        type: 'POST',
        data: $('#formAjout').serialize(),
        dataType: 'xml',
        success: function(reponse){
          affichageFilms('ajouter', reponse)
        }
      });
    break;
    case 'afficher':
      $.ajax({
        url: 'gestionFilms.php',
        type: 'POST',
        data: {'action':'afficher'},
        dataType: 'xml',
        success: function(reponse){
          affichageFilms('afficher', reponse)
        }
      });
    break;
    case 'classer':
      $.ajax({
        url: 'gestionFilms.php',
        type: 'POST',
        data: {'action':'classer'},
        dataType: 'xml',
        success: function(reponse){
          affichageFilms('classer', reponse)
        }
      });
    break;
    case 'rechercher':
      $.ajax({
        url: 'gestionFilms.php',
        type: 'POST',
        data: $('#formRecherche').serialize(),
        dataType: 'xml',
        success: function(reponse){
          affichageFilms('rechercher', reponse)
        }
      });
    break;
  }
}
