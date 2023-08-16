/*************************************************************************************************************
À propos des différentes parties du script :
  1) partie sur l'affichage simple de trois tableaux (patients, établissements et hospitalisations);
  2) partie sur le sélecteur des hospitalisations par patients;
  3) partie sur l'affichage, ou le listage, du tableau des hospitalisations par patients;
  4 et 5) parties sur les sélecteurs des hospitalisations par établissement et par spécialité respectivement;
  6) partie sur l'affichage, ou le triage, du tableau des hospitalisations par établissement et spécialité.
*************************************************************************************************************/


// ESPACE D'AFFICHAGE DES TABLEAUX
function afficher(code) {
  var tableau;
  var status;
  var i;
  // on relie le code entre trois boutons
  switch(code) {
    case 1 :
    tableau = tabPatients;
    status = "Nombre de patients : ";
    break;
    case 2 :
    tableau = tabEtablissements;
    status = "Nombre d'établissements : ";
    break;
    case 3 :
    tableau = tabHospitalisations;
    status = "Nombre d'hospitalisations : ";
    break;
  }
  // on prépare l'affichage
  document.getElementById("liste").style.display = "none";
  document.getElementById("tri_1").style.display = "none";
  document.getElementById("tri_2").style.display = "none";
  var affichage = document.getElementById("affichage");
  if (affichage.style.display = "none") {
    affichage.style.display = "block";
    // on fait le tableau HTML
    var table = document.createElement("table");
    affichage.innerHTML = "";
    affichage.appendChild(table);
    // on récupère les objets JSON
    var trHead = document.createElement("tr");
    for (var h in tableau[0]) {
      // on affiche les objets JSON
      var th = document.createElement("th");
      th.innerHTML = h;
      table.appendChild(trHead);
      trHead.appendChild(th);
    }
    // on parcours les bases de données
    for (i = 0; i < tableau.length; i++) {
      var tr = document.createElement("tr");
      // on récupère les données
      for (var j in tableau[i]) {
        // on affiche les données
        var td = document.createElement("td");
        td.innerHTML = tableau[i][j];
        table.appendChild(tr);
        tr.appendChild(td);  
      }
    }
    // on ajoute un bouton « retour »
    var retour = document.createElement("button");
    retour.innerHTML = "retour";
    affichage.appendChild(retour);
    retour.onclick = function() {
      affichage.style.display = "none";
    }
    // on indique le status après utilisation
    var p = document.createElement("p");
    p.innerHTML = status + i;
    p.style.color = "green";
    affichage.appendChild(p);
  }
}


// CHAQUE HOSPITALISATION PAR PATIENT
function lister() {
  // on prépare l'affichage
  document.getElementById("tri_1").style.display = "none";
  document.getElementById("tri_2").style.display = "none";
  document.getElementById("affichage").style.display = "none";
  // on fait la liste de sélection HTML
  var liste = document.getElementById("liste");
  liste.innerHTML = "";
  if (liste.style.display = "none") {
    liste.style.display = "block";
    // on fait ensuite les options
    var options = document.createElement("option");
    options.setAttribute("value", "");
    var option = document.createTextNode("choisir");
    liste.appendChild(options);
    options.appendChild(option);
    // on ajoute les données d'option au sélecteur HTML
    for (var i in tabPatients) { 
      liste.options[liste.options.length] = new Option(tabPatients[i]["Dossier"]);
    }
  }
}


// HOSPITALISATIONS PAR PATIENT SÉLECTIONNÉ
function listage(code){
  var i;
  // on prépare l'affichage
  var affichage = document.getElementById("affichage");
  affichage.style.display = "block";
  affichage.innerHTML = "";
  // on indique le nom complet du patient sélectionné
  var h3 = document.createElement("h3");
  affichage.appendChild(h3);
  // on parcours les bases de données
  for (i = 0; i < tabPatients.length; i++) {
    // on trie les données, puis on les affiche
    if (code.value == tabPatients[i]["Dossier"]) {
      h3.innerHTML = tabPatients[i]["Prénom"] + " " + tabPatients[i]["Nom"];
    }
  }
  // on fait le tableau HTML
  var table = document.createElement("table");
  table.id = "tableau";
  affichage.appendChild(table);
  // on récupère les objets JSON
  var trHead = document.createElement("tr");
  for (var h in tabHospitalisations[0]) {
    // on affiche les objets JSON
    var th = document.createElement("th");
    th.innerHTML = h;
    table.appendChild(trHead);
    trHead.appendChild(th);
  }
  // on parcours les bases de données
  for (i = 0; i < tabHospitalisations.length; i++) {
    var tr = document.createElement("tr");
    // on récupère les données
    if (code.value == tabHospitalisations[i]["No dossier patient"]) {
      for (var j in tabHospitalisations[i]) {
        // on affiche les données
        var td = document.createElement("td");
        td.innerHTML = tabHospitalisations[i][j];
        table.appendChild(tr);
        tr.appendChild(td);  
      }
    }
  }
  // on ajoute un bouton « retour »
  var retour = document.createElement("button");
  retour.innerHTML = "retour";
  affichage.appendChild(retour);
  retour.onclick = function() {
    affichage.style.display = "none";
    // on retire aussi la liste de sélection en plus de l'affichage
    document.getElementById("liste").style.display = "none";
  }
  // on indique le status après utilisation
  var p = document.createElement("p");
  var t = document.getElementById("tableau").rows;
  var qte = t.length-1;
  // condition s'il y a ou non des entrées pour un dossier donné
  if (qte < 1) {
    p.innerHTML = "Aucune hospitalisation au dossier.";
    p.style.color = "red";
  } else {
    p.innerHTML = "Quantité en hospitalisation : " + qte;
    p.style.color = "green";
  }
  affichage.appendChild(p);
}


// CHAQUE HOSPITALISATION PAR ÉTABLISSEMENT
function trier() {
  // on prépare l'affichage
  document.getElementById("liste").style.display = "none";
  document.getElementById("affichage").style.display = "none";
  // on fait la liste de sélection HTML
  var tri_1 = document.getElementById("tri_1");
  tri_1.innerHTML = "";
  if (tri_1.style.display = "none") {
    tri_1.style.display = "block";
    // on fait ensuite les options
    var options = document.createElement("option");
    options.setAttribute("value", "");
    var option = document.createTextNode("choisir");
    tri_1.appendChild(options);
    options.appendChild(option);
    // on ajoute les données d'option au sélecteur HTML
    for (var i in tabEtablissements) {
      tri_1.options[tri_1.options.length] = new Option(tabEtablissements[i]["Établissement"]);
    }
  }
}


// CHAQUE HOSPITALISATION PAR SPÉCIALITÉ
function triage_1(code) {
  // on prépare l'affichage
  document.getElementById("affichage").style.display = "none";
  // on fait la liste de sélection HTML
  var tri_2 = document.getElementById("tri_2");
  tri_2.innerHTML = "";
    if (tri_2.style.display = "none") {
    tri_2.style.display = "block";
    // on fait ensuite les options
    var sousOptions = document.createElement("option");
    sousOptions.setAttribute("value", "");
    var sousOption = document.createTextNode("choisir");
    tri_2.appendChild(sousOptions);
    sousOptions.appendChild(sousOption);
    // on ajoute les données d'option au sélecteur HTML
    for (var i in tabHospitalisations) {
      if (code.value == tabHospitalisations[i]["Code établissement"] && tri_2.options[tri_2.options.length-1].value != tabHospitalisations[i]["Spécialité"]) {
        tri_2.options[tri_2.options.length] = new Option(tabHospitalisations[i]["Spécialité"]);
        tri_2.style.visibility = "visible";   
      }
    }
  } 
}


// HOSPITALISATIONS PAR ÉTABLISSEMENT ET PAR SPÉCIALITÉ
function triage_2() {
  var i;
  // on prépare l'affichage
  var affichage = document.getElementById("affichage");
  affichage.style.display = "block";
  affichage.innerHTML = "";
  // on attribue des codes pour les valeurs choisies dans les deux sélecteurs
  var code_1 = document.getElementById('tri_1').value;
  var code_2 = document.getElementById('tri_2').value;
  // on indique le nom de l'établissement sélectionné
  var h3 = document.createElement("h3");
  affichage.appendChild(h3);
  // on parcours les bases de données
  for (i = 0; i < tabEtablissements.length; i++) {
    // on trie les données, puis on les affiche
    if (code_1 == tabEtablissements[i]["Établissement"]) {
      h3.innerHTML = tabEtablissements[i]["Nom"];
    }
  }
  // on fait le tableau HTML
  var table = document.createElement("table");
  table.id = "tableau";
  affichage.appendChild(table);
  // on récupère les objets JSON
  var trHead = document.createElement("tr");
  for (var h in tabHospitalisations[0]) {
    // on affiche les objets JSON
    var th = document.createElement("th");
    th.innerHTML = h;
    table.appendChild(trHead);
    trHead.appendChild(th);
  }
  // on parcours les bases de données
  for (i = 0; i < tabHospitalisations.length; i++) {
    var tr = document.createElement("tr");
    // on récupère les données
    if (code_1 == tabHospitalisations[i]["Code établissement"] && code_2 == tabHospitalisations[i]["Spécialité"]) {
      for (var j in tabHospitalisations[i]) {
        // on affiche les données
        var td = document.createElement("td");
        td.innerHTML = tabHospitalisations[i][j];
        table.appendChild(tr);
        tr.appendChild(td);  
      }
    }
  }
  // on ajoute un bouton « retour »
  var retour = document.createElement("button");
  retour.innerHTML = "retour";
  affichage.appendChild(retour);
  retour.onclick = function() {
    affichage.style.display = "none";
    // on retire aussi la liste de sélection en plus de l'affichage
    document.getElementById("tri_1").style.display = "none";
    document.getElementById("tri_2").style.display = "none";
  }
  // on indique le status après utilisation
  var p = document.createElement("p");
  var t = document.getElementById("tableau").rows;
  var qte = t.length-1;
  p.innerHTML = "Quantité en hospitalisation : " + qte;
  p.style.color = "green";
  affichage.appendChild(p);
}