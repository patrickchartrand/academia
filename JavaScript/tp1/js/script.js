// PATRICK CHARTRAND (20017273)

// ZONE DES TABLEAUX
// tableau des différents thés
var tabThe=new Array();
// tableau associatif sur chaque menu et données relatives
tabThe[0]=new Array();
tabThe[0]['menu']='Choose your tea';
tabThe[0]['prix']=0;
tabThe[0]['image']='images/blank.jpg';
tabThe[1]=new Array();
tabThe[1]['menu']='White tea';
tabThe[1]['prix']=5.95;
tabThe[1]['image']='images/whiteTea.jpg';
tabThe[2]=new Array();
tabThe[2]['menu']='Wulong tea';
tabThe[2]['prix']=4.95;
tabThe[2]['image']='images/wulongTea.jpg';

// tableau des différents desserts
var tabDessert=new Array();
// tableau associatif sur chaque menu et données relatives
tabDessert[0]=new Array();
tabDessert[0]['menu']='Choose your pastry';
tabDessert[0]['prix']=0;
tabDessert[0]['image']='images/blank.jpg';
tabDessert[1]=new Array();
tabDessert[1]['menu']='Chocolate cake';
tabDessert[1]['prix']=8.95;
tabDessert[1]['image']='images/chocolateCake.jpg';
tabDessert[2]=new Array();
tabDessert[2]['menu']='Rhubarb pie';
tabDessert[2]['prix']=9.95;
tabDessert[2]['image']='images/rhubarbPie.jpg';


// CHARGEMENT DES DONNÉES
// on charge les listes déroulantes 'SELECT' sur activation de la page
function charger(){

    // on affiche la première image par défaut et on inscrit les propriétés de l'image
    var imgThe=new Image(150, 150);
    imgThe.src=tabThe[0]['image'];
    imgThe.id="image1";
    document.getElementById("imageThe").appendChild(imgThe);
    // et on affiche aussi la seconde image par défaut et on inscrit les propriétés de l'image
    var imgDessert=new Image(150, 150);
    imgDessert.src=tabDessert[0]['image'];
    imgDessert.id="image2";
    document.getElementById("imageDessert").appendChild(imgDessert);

    // on relie les données des tableaux aux listes déroulantes 'SELECT'
    var selThe=document.getElementById('selThe');
    var selDessert=document.getElementById('selDessert');

    // on distingue chaque the du tableau, et en faisant une variable
    for(var i=0;i<tabThe.length;i++) {
        var choixThe=tabThe[i];
        // on ajoute la donnée 'menu' de chaque the à la liste déroulante
        selThe.options[selThe.options.length]=new Option(choixThe['menu']);
    }

    // on distingue chaque dessert du tableau, et en faisant une variable
    for(var i=0;i<tabDessert.length;i++) {
        var choixDessert=tabDessert[i];
        // on ajoute la donnée 'menu' de chaque dessert à la liste déroulante
        selDessert.options[selDessert.options.length]=new Option(choixDessert['menu']);
    }

}


// AFFICHAGE DES DONNÉES
// on affiche les autres données associées à l'option sélectionnée dans les listes déroulantes
function afficher(){

    // on continue à partir des données sélectionnées
    var menuThe=selThe.selectedIndex;
    var menuDessert=selDessert.selectedIndex;
    // puis on prend les autres données associées au menu qui a été sélectionné
    var tabMenuThe=tabThe[menuThe];
    var tabMenuDessert=tabDessert[menuDessert];

    // on affiche la première image selon le menu sélectionné
    var imgThe=document.getElementById('image1');
    imgThe.src=tabMenuThe['image'];
    // et on affiche aussi la seconde image selon le menu sélectionné
    var imgDessert=document.getElementById('image2');
    imgDessert.src=tabMenuDessert['image'];

    // on relie les espaces d'affichages pour les prix
    var prixThe=document.getElementById('prixThe');
    var prixDessert=document.getElementById('prixDessert');
    // puis on affiche les prix dans les espaces appropriés selon le menu sélectionné
    prixThe.innerHTML=tabMenuThe['prix']+' $';
    prixDessert.innerHTML=tabMenuDessert['prix']+' $';

    // condition afin que les prix nuls ne soient pas affichés pour les thés
    if (tabMenuThe['prix']==0 && tabMenuDessert['prix']>=0) {
        prixThe.style.visibility = 'hidden';
    } else if (tabMenuThe['prix']>0 && tabMenuDessert['prix']>=0) {
        prixThe.style.visibility='visible';
        // condition afin que les prix nuls ne soient pas affichés pour les desserts
        } if (tabMenuDessert['prix']==0 && tabMenuThe['prix']>=0) {
            prixDessert.style.visibility='hidden';
            } else if (tabMenuDessert['prix']>0 && tabMenuThe['prix']>=0) {
                prixDessert.style.visibility='visible';
                }

    // on relie les données de coûts à l'espace d'affichage pour l'addition
    var addition=document.getElementById('addition');
    // on calcule les prix, limitant leur nombre à deux décimales
    var sousTotal=(tabMenuThe['prix']+tabMenuDessert['prix']).toFixed(2);
    var taxes=((tabMenuThe['prix']+tabMenuDessert['prix'])*0.15).toFixed(2);
    var total=((tabMenuThe['prix']+tabMenuDessert['prix'])*(1+0.15)).toFixed(2);
    // puis on affiche l'addition dans l'espace approprié selon les plats sélectionnés
    addition.innerHTML='<i>Sous-total</i> : '+sousTotal+' $&emsp;&emsp;<i>Taxes</i> : '+taxes+' $&emsp;&emsp;<i>Total</i> : '+total+' $';

    // condition afin que l'addition soit affichée que si elle n'est pas nulle
    if (total==0) {
        addition.style.visibility='hidden';
    } else if (total>0) {
        addition.style.visibility='visible';
        }

}
