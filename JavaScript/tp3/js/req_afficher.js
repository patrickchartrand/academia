function afficher(code) {
	// INITIALISATION DE LA FONCTION
	// on fait les variables pour relier le script à l'un des trois documents et à un élément précis
	var srcDoc, elem;
	if (code == 1) {
		srcDoc = "donnees/patients.xml";
		elem = "patient";
	} else if (code == 2) {
		srcDoc = "donnees/etablissements.xml";
		elem = "etablissement";
	} else if (code == 3) {
		srcDoc = "donnees/hospitalisations.xml";
		elem = "hospitalisation";
	}

	// on envoie la requête XML
	var xhr = new XMLHttpRequest();
	xhr.onload = function(){
		if (xhr.status === 200) {
			var xmlDoc = xhr.responseXML;
			var donnees = xmlDoc.getElementsByTagName(elem);


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

			switch(code) {
				case 1 :
					// ENTÊTE DU TABLEAU
					// on fait une ligne pour les titres de colonnes
					var tr = document.createElement("tr");
					thead.appendChild(tr);
					
					// on inscrit les titres de colonnes
					var titr1, titr2, titr3, titr4, titr5;
					
					// titre 1
					titr1 = document.createElement("th");
					titr1.appendChild(document.createTextNode("no. de dossier"));
					tr.appendChild(titr1);

					// titre 2
					titr2 = document.createElement("th");
					titr2.appendChild(document.createTextNode("nom"));
					tr.appendChild(titr2);

					// titre 3
					titr3 = document.createElement("th");
					titr3.appendChild(document.createTextNode("prénom"));
					tr.appendChild(titr3);

					// titre 4
					titr4 = document.createElement("th");
					titr4.appendChild(document.createTextNode("date de naissance"));
					tr.appendChild(titr4);

					// titre 5
					titr5 = document.createElement("th");
					titr5.appendChild(document.createTextNode("sexe"));
					tr.appendChild(titr5);
					

					// CORPS DU TABLEAU
					// on calcul le nombre de données liées
					for (var i = 0; i < donnees.length; i++) {
						// on fait une ligne pour chaque données liées
						let tr = document.createElement("tr");
						tbody.appendChild(tr);

						// on récupère les données dans les attributs et éléments
						var attr1, elem1, elem2, elem3, elem4;
						
						// attribut 1
						attr1 = document.createElement("td");
						attr1.appendChild(document.createTextNode(donnees[i].getAttribute("noDossier")));
						tr.appendChild(attr1);

						// élément 1
						elem1 = document.createElement("td");
						elem1.appendChild(document.createTextNode(getNodeValue(donnees[i], "nom")));
						tr.appendChild(elem1);

						// élément 2
						elem2 = document.createElement("td");
						elem2.appendChild(document.createTextNode(getNodeValue(donnees[i], "prenom")));
						tr.appendChild(elem2);	

						// élément 3
						elem3 = document.createElement("td");
						elem3.appendChild(document.createTextNode(getNodeValue(donnees[i], "naissance")));
						tr.appendChild(elem3);

						// élément 4
						elem4 = document.createElement("td");
						elem4.appendChild(document.createTextNode(getNodeValue(donnees[i], "sexe")));
						tr.appendChild(elem4);
					}
				break;
				case 2 :
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
					titr2.appendChild(document.createTextNode("nom"));
					tr.appendChild(titr2);

					// titre 3
					titr3 = document.createElement("th");
					titr3.appendChild(document.createTextNode("adresse"));
					tr.appendChild(titr3);

					// titre 4
					titr4 = document.createElement("th");
					titr4.appendChild(document.createTextNode("code postal"));
					tr.appendChild(titr4);

					// titre 5
					titr5 = document.createElement("th");
					titr5.appendChild(document.createTextNode("téléphone"));
					tr.appendChild(titr5);
					

					// CORPS DU TABLEAU
					// on calcul le nombre de données liées
					for (var i = 0; i < donnees.length; i++) {
						// on fait une ligne pour chaque données liées
						let tr = document.createElement("tr");
						tbody.appendChild(tr);

						// on récupère les données dans les attributs et éléments
						var attr1, elem1, elem2, elem3, elem4;
						
						// attribut 1
						attr1 = document.createElement("td");
						attr1.appendChild(document.createTextNode(donnees[i].getAttribute("code")));
						tr.appendChild(attr1);

						// élément 1
						elem1 = document.createElement("td");
						elem1.appendChild(document.createTextNode(getNodeValue(donnees[i], "nom")));
						tr.appendChild(elem1);

						// élément 2
						elem2 = document.createElement("td");
						elem2.appendChild(document.createTextNode(getNodeValue(donnees[i], "adresse")));
						tr.appendChild(elem2);	

						// élément 3
						elem3 = document.createElement("td");
						elem3.appendChild(document.createTextNode(getNodeValue(donnees[i], "codePostal")));
						tr.appendChild(elem3);

						// élément 4
						elem4 = document.createElement("td");
						elem4.appendChild(document.createTextNode(getNodeValue(donnees[i], "telephone")));
						tr.appendChild(elem4);
					}
				break;
				case 3 :
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