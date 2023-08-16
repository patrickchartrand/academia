function rechercher(code) {
	// INITIALISATION DE LA FONCTION
	// on fait les variables pour relier le script à l'un des trois documents et à un élément précis
	var srcDoc, elem;
	if (code == 1) {
		srcDoc = "donnees/patients.xml";
		elem = "patient";
	} else if (code == 2) {
		srcDoc = "donnees/etablissements.xml";
		elem = "etablissement";
	}

	// on envoie la requête XML
	var xhr = new XMLHttpRequest();
	xhr.onload = function(){
		if (xhr.status === 200) {
			var xmlDoc = xhr.responseXML;
			var donnees = xmlDoc.getElementsByTagName(elem);

			// on prépare l'espace d'affichage
			var affichage = document.getElementById("affichage");
			affichage.innerHTML = "";

			switch(code) {
				case 1 :
					// LISTE DE SÉLECTION
					// on fait le sélecteur
					var select = document.createElement("select");
					select.setAttribute("id", "liste_hospitalPatients");
					select.addEventListener("change", lister_hospitalPatients);
					affichage.appendChild(select);

					// on fait chaque option
					var option = document.createElement("option");
					option.setAttribute("value", "");

					// on fait un option par défaut
					select.appendChild(option);
					option.appendChild(document.createTextNode("choisir"));

					// on prend tous les numéros de dossier
					for (var i in donnees) {
						select.options[select.options.length] = new Option(donnees[i].getAttribute("noDossier"));
					}
				break;
				case 2 :
					// LISTE DE SÉLECTION
					// on fait le sélecteur
					var select = document.createElement("select");
					select.setAttribute("id", "liste_hospitalEtablissements_1");
					select.addEventListener("change", lister_hospitalEtablissements_1);
					affichage.appendChild(select);

					// on fait chaque option
					var option = document.createElement("option");
					option.setAttribute("value", "");

					// on fait un option par défaut
					select.appendChild(option);
					option.appendChild(document.createTextNode("choisir"));

					// on prend tous les numéros de dossier
					for (var i in donnees) {
						select.options[select.options.length] = new Option(donnees[i].getAttribute("code"));
					}
				break;
			}


			// REQUÊTE XML
			// on ajoute le contenu du document
			function getNodeValue(obj, tag) {
				return obj.getElementsByTagName(tag)[0].firstChild.nodeValue;
			}
		}
	};
	// on charge le contenu du document
	xhr.open("GET", srcDoc, true);
	xhr.send(null);
}


function lister_hospitalPatients() {
	// INITIALISATION DE LA FONCTION
	// on retrouve l'indice sélectionné
	var donneeSel = document.getElementById("liste_hospitalPatients");
 	var indice = donneeSel.options[donneeSel.selectedIndex].value; 

	// on envoie la requête XML
	var xhr = new XMLHttpRequest();
	xhr.onload = function(){
		if (xhr.status === 200) {
			var xmlDoc = xhr.responseXML;
			var donnees = xmlDoc.getElementsByTagName("hospitalisation");


			// TABLEAU
			// on fait les variables de base pour afficher les tableaux
			var affichage, button, table, thead, tbody;
			
			// on fait l'espace d'affichage
			affichage = document.getElementById("affichage");
			affichage.innerHTML = "";
			
			// on fait le bouton de retour
			button = document.createElement("button");
			affichage.appendChild(button);
			button.appendChild(document.createTextNode("retour"));
			
			// on crée un effet jQuery pour retourner
			$(document).ready(function(){
    			$("button").click(function(){
        			$("table").hide();
        			$("button").hide();
    			});
			});
			
			// on prépare la structure du tableau
			table = document.createElement("table");
			thead = document.createElement("thead");
			tbody = document.createElement("tbody");
			table.appendChild(tbody);
			table.insertBefore(thead, tbody);
			affichage.appendChild(table);


			// ENTÊTE DU TABLEAU
			// on fait une ligne pour les titres de colonnes
			var tr = document.createElement("tr");
			thead.appendChild(tr);
			
			// on inscrit les titres de colonnes
			var titr1, titr2, titr3, titr4, titr5;
			
			// titre 1
			titr1 = document.createElement("th");
			titr1.appendChild(document.createTextNode("code d'établissement"));
			tr.appendChild(titr1);

			// titre 2
			titr2 = document.createElement("th");
			titr2.appendChild(document.createTextNode("no. de dossier"));
			tr.appendChild(titr2);

			// titre 3
			titr3 = document.createElement("th");
			titr3.appendChild(document.createTextNode("date d'admission"));
			tr.appendChild(titr3);

			// titre 4
			titr4 = document.createElement("th");
			titr4.appendChild(document.createTextNode("date de sortie"));
			tr.appendChild(titr4);

			// titre 5
			titr5 = document.createElement("th");
			titr5.appendChild(document.createTextNode("spécialité"));
			tr.appendChild(titr5);
			

			// CORPS DU TABLEAU
			// on calcul le nombre de données liées
			for (var i = 0; i < donnees.length; i++) {

				// on fait une condition pour que les données correspondent au numéro de dossier sélectionné, c-à-d à l'indice
				if (indice == donnees[i].getAttribute("noDossier")) {

					// on fait une ligne pour chaque données liées
					let tr = document.createElement("tr");
					tbody.appendChild(tr);

					// on récupère les données dans les attributs et éléments
					var attr1, attr2, elem1, elem2, elem3;
					
					// attribut 1
					attr1 = document.createElement("td");
					attr1.appendChild(document.createTextNode(donnees[i].getAttribute("codeEtablissement")));
					tr.appendChild(attr1);

					// attribut 2
					attr2 = document.createElement("td");
					attr2.appendChild(document.createTextNode(donnees[i].getAttribute("noDossier")));
					tr.appendChild(attr2);

					// élément 1
					elem1 = document.createElement("td");
					elem1.appendChild(document.createTextNode(getNodeValue(donnees[i], "dateAdmission")));
					tr.appendChild(elem1);

					// élément 2
					elem2 = document.createElement("td");
					elem2.appendChild(document.createTextNode(getNodeValue(donnees[i], "dateSortie")));
					tr.appendChild(elem2);	

					// élément 3
					elem3 = document.createElement("td");
					elem3.appendChild(document.createTextNode(getNodeValue(donnees[i], "specialite")));
					tr.appendChild(elem3);
				}
			}


			// REQUÊTE XML
			// on ajoute le contenu du document
			function getNodeValue(obj, tag) {
				return obj.getElementsByTagName(tag)[0].firstChild.nodeValue;
			}
		}
	};
	// on charge le contenu du document
	xhr.open("GET", "donnees/hospitalisations.xml", true);
	xhr.send(null);
}


function lister_hospitalEtablissements_1() { /* sous-liste avant d'afficher le tableau */
	// INITIALISATION DE LA FONCTION
	// on retrouve l'indice sélectionné
	var donneeSel = document.getElementById("liste_hospitalEtablissements_1");
 	var indice = donneeSel.options[donneeSel.selectedIndex].value; 

	// on envoie la requête XML
	var xhr = new XMLHttpRequest();
	xhr.onload = function(){
		if (xhr.status === 200) {
			var xmlDoc = xhr.responseXML;
			var donnees = xmlDoc.getElementsByTagName("hospitalisation");


			// LISTE DE SÉLECTION
			// on fait le sélecteur
			var affichage = document.getElementById("affichage");
			var select = document.createElement("select");
			select.setAttribute("id", "liste_hospitalEtablissements_2");
			select.addEventListener("change", lister_hospitalEtablissements_2);
			affichage.appendChild(select);

			// on fait une condition pour avoir un seul sélecteur ici si le premier est cliqué
			var sel = document.getElementById("liste_hospitalEtablissements_2");
			if (sel.hasChildNodes()) {
				affichage.removeChild(affichage.lastChild);
			}

			// on fait chaque option
			var option = document.createElement("option");
			option.setAttribute("value", "");

			// on fait un option par défaut
			select.appendChild(option);
			option.appendChild(document.createTextNode("choisir"));

			// on prend tous les numéros de dossier
			for (var i in donnees) {
				var j = donnees[i].getElementsByTagName("specialite")[0].firstChild.nodeValue;
				if (indice == donnees[i].getAttribute("codeEtablissement") && select.options[select.options.length-1].value != j) {
					select.options[select.options.length] = new Option(j);
				}
			}


			// REQUÊTE XML
			// on ajoute le contenu du document
			function getNodeValue(obj, tag) {
				return obj.getElementsByTagName(tag)[0].firstChild.nodeValue;
			}
		}
	};
	// on charge le contenu du document
	xhr.open("GET", "donnees/hospitalisations.xml", true);
	xhr.send(null);
}


function lister_hospitalEtablissements_2() {
	// INITIALISATION DE LA FONCTION
	// on retrouve les indices sélectionnés
	var donneeSel1 = document.getElementById("liste_hospitalEtablissements_1");
 	var indice1 = donneeSel1.options[donneeSel1.selectedIndex].value; 
	var donneeSel2 = document.getElementById("liste_hospitalEtablissements_2");
 	var indice2 = donneeSel2.options[donneeSel2.selectedIndex].value; 

	// on envoie la requête XML
	var xhr = new XMLHttpRequest();
	xhr.onload = function(){
		if (xhr.status === 200) {
			var xmlDoc = xhr.responseXML;
			var donnees = xmlDoc.getElementsByTagName("hospitalisation");


			// TABLEAU
			// on fait les variables de base pour afficher les tableaux
			var affichage, button, table, thead, tbody;
			
			// on fait l'espace d'affichage
			affichage = document.getElementById("affichage");
			affichage.innerHTML = "";
			
			// on fait le bouton de retour
			button = document.createElement("button");
			affichage.appendChild(button);
			button.appendChild(document.createTextNode("retour"));
			
			// on crée un effet jQuery pour retourner
			$(document).ready(function(){
    			$("button").click(function(){
        			$("table").hide();
        			$("button").hide();
    			});
			});
			
			// on prépare la structure du tableau
			table = document.createElement("table");
			thead = document.createElement("thead");
			tbody = document.createElement("tbody");
			table.appendChild(tbody);
			table.insertBefore(thead, tbody);
			affichage.appendChild(table);


			// ENTÊTE DU TABLEAU
			// on fait une ligne pour les titres de colonnes
			var tr = document.createElement("tr");
			thead.appendChild(tr);
			
			// on inscrit les titres de colonnes
			var titr1, titr2, titr3, titr4, titr5;
			
			// titre 1
			titr1 = document.createElement("th");
			titr1.appendChild(document.createTextNode("code d'établissement"));
			tr.appendChild(titr1);

			// titre 2
			titr2 = document.createElement("th");
			titr2.appendChild(document.createTextNode("no. de dossier"));
			tr.appendChild(titr2);

			// titre 3
			titr3 = document.createElement("th");
			titr3.appendChild(document.createTextNode("date d'admission"));
			tr.appendChild(titr3);

			// titre 4
			titr4 = document.createElement("th");
			titr4.appendChild(document.createTextNode("date de sortie"));
			tr.appendChild(titr4);

			// titre 5
			titr5 = document.createElement("th");
			titr5.appendChild(document.createTextNode("spécialité"));
			tr.appendChild(titr5);
			

			// CORPS DU TABLEAU
			// on calcul le nombre de données liées
			for (var i = 0; i < donnees.length; i++) {

				// on fait une condition pour que les données correspondent au code d'établissement et à la spécialité sélectionnés, c-à-d aux indices
				var j = donnees[i].getElementsByTagName("specialite")[0].firstChild.nodeValue;
				if (indice1 == donnees[i].getAttribute("codeEtablissement") && indice2 == j) {

					// on fait une ligne pour chaque données liées
					let tr = document.createElement("tr");
					tbody.appendChild(tr);

					// on récupère les données dans les attributs et éléments
					var attr1, attr2, elem1, elem2, elem3;
					
					// attribut 1
					attr1 = document.createElement("td");
					attr1.appendChild(document.createTextNode(donnees[i].getAttribute("codeEtablissement")));
					tr.appendChild(attr1);

					// attribut 2
					attr2 = document.createElement("td");
					attr2.appendChild(document.createTextNode(donnees[i].getAttribute("noDossier")));
					tr.appendChild(attr2);

					// élément 1
					elem1 = document.createElement("td");
					elem1.appendChild(document.createTextNode(getNodeValue(donnees[i], "dateAdmission")));
					tr.appendChild(elem1);

					// élément 2
					elem2 = document.createElement("td");
					elem2.appendChild(document.createTextNode(getNodeValue(donnees[i], "dateSortie")));
					tr.appendChild(elem2);	

					// élément 3
					elem3 = document.createElement("td");
					elem3.appendChild(document.createTextNode(getNodeValue(donnees[i], "specialite")));
					tr.appendChild(elem3);
				}
			}


			// REQUÊTE XML
			// on ajoute le contenu du document
			function getNodeValue(obj, tag) {
				return obj.getElementsByTagName(tag)[0].firstChild.nodeValue;
			}
		}
	};
	// on charge le contenu du document
	xhr.open("GET", "donnees/hospitalisations.xml", true);
	xhr.send(null);
}