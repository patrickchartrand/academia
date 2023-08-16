function afficher(donnees){
	var txt="<div class='album py-5'>";
  	txt+="<div class='container'>";
  	txt+="<div class='row'>";
  
	var tabFilms=donnees.getElementsByTagName('film');
	for(var i=0; i<tabFilms.length; i++){
		var tabFilm=tabFilms[i];
		var id=tabFilm.getElementsByTagName('id')[0].firstChild.nodeValue;
		var title=tabFilm.getElementsByTagName('title')[0].firstChild.nodeValue;
		var producer=tabFilm.getElementsByTagName('producer')[0].firstChild.nodeValue;
		var genre=tabFilm.getElementsByTagName('genre')[0].firstChild.nodeValue;
		var duration=tabFilm.getElementsByTagName('duration')[0].firstChild.nodeValue;
		var price=tabFilm.getElementsByTagName('price')[0].firstChild.nodeValue;
		var quantity=tabFilm.getElementsByTagName('quantity')[0].firstChild.nodeValue;
		var image=tabFilm.getElementsByTagName('image')[0].firstChild.nodeValue;
		var video=tabFilm.getElementsByTagName('video')[0].firstChild.nodeValue;

    	txt+="<div class='col-md-4'>";
    	txt+="<div class='card mb-4 box-shadow'>";
    	txt+="<a class='link-img' data-toggle='modal' data-target='#"+id+"'><img class='bd-placeholder-img' width='100%' height='500' src='images/"+image+"'/></a>";
    	txt+="<div class='card-body'>";
    	txt+="<p class='card-text'><b>"+title+"</b><br/>"+producer+"<br/>"+price+"$</p>";
    	txt+="<div class='d-flex justify-content-between align-items-center'>";
    	txt+="<small class='text-muted'>"+duration+" minutes</small>";
    	txt+="</div></div></div></div>";
    	// on fait un effet « modal »
	    txt+="<div class='modal fade' id='"+id+"' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
	    txt+="<div class='modal-dialog' role='document'>";
	    txt+="<div class='modal-content'>";
	    txt+="<div class='modal-header'>";
	    txt+="<h2 class='modal-title'>"+title+"</h2>";
	    txt+="<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
	    txt+="<span aria-hidden='true'>&times;</span>";
	    txt+="</button></div>";
	    txt+="<div class='modal-body'>";
	    txt+="<video width='100%' controls>";
	    txt+="<source src='videos/"+video+"' type='video/mp4'>";
	    txt+="</video>";
	    txt+="</div>";
	    txt+="<div class='modal-footer'>";
	    txt+="<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fermer</button>";
	    txt+="</div></div></div></div>";
	}

	txt+="</div></div></div>";
	$("#contenu").html(txt);
}

function classer(donnees){
	var opt="<option disabled selected>Genres</option>"; 

	var tabFilms=donnees.getElementsByTagName('film');
	for(var i=0; i<tabFilms.length; i++){
		var tabFilm=tabFilms[i];
		var id=tabFilm.getElementsByTagName('id')[0].firstChild.nodeValue;
		var title=tabFilm.getElementsByTagName('title')[0].firstChild.nodeValue;
		var producer=tabFilm.getElementsByTagName('producer')[0].firstChild.nodeValue;
		var genre=tabFilm.getElementsByTagName('genre')[0].firstChild.nodeValue;
		var duration=tabFilm.getElementsByTagName('duration')[0].firstChild.nodeValue;
		var price=tabFilm.getElementsByTagName('price')[0].firstChild.nodeValue;
		var quantity=tabFilm.getElementsByTagName('quantity')[0].firstChild.nodeValue;
		var image=tabFilm.getElementsByTagName('image')[0].firstChild.nodeValue;
		var video=tabFilm.getElementsByTagName('video')[0].firstChild.nodeValue;

		opt+="<option value='"+genre+"'>"+genre+"</option>";
	}

	$("#options").html(opt);
}

var affichageFilms=function(action, donnees){
  switch(action){
	case 'ajouter':
		$(document).ready(function(){
			var information=donnees.getElementsByTagName('info')[0].firstChild.nodeValue;
			$('#divInfo').html(information);		
			$('#divInfo').css('color','red');
			setTimeout(function(){ 
				document.getElementById("divInfo").innerHTML="";
			}, 5000);
		});
	break;
    case 'afficher':
      	afficher(donnees);
    break;
    case 'classer':
    	classer(donnees);
    break;
    case 'rechercher':
    	afficher(donnees); // même structure de code
    break;
  }
}
