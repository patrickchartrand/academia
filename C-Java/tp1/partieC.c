/* 
  Travail pratique #1
  Auteur : Patrick Chartrand (20017273)
  Date : 13 février 2020
*/



/* PARTIE C */
#include <stdio.h>
#include <ctype.h>

int main(){
  
  char formeGeo, choix;
  int nbRectangle = 0;
  const float PI = 3.14159;
  float rayon, longueur, largeur, cote, perimetre, surface, somSurface = 0.0, plusGrandCercle = 0.0, plusGrandRectangle = 0.0, plusPetitCarre = 999999.99;
  
  /* boucle afin de traiter plusieurs usagers */
  do{
    /* saisie de la donnée reliée au sexe */
    printf("\nSaisissez la forme géométrique à traiter (C pour un cercle, R pour rectangle ou K pour un carré) : \n");
    scanf(" %c", &formeGeo);

    /* aussi bien majuscule que minuscule */
    formeGeo = toupper(formeGeo);

    /* association des formes géométriques à leur lettre de référence */
    switch(formeGeo){
      case 'C':
        printf("Entrez la mesure du rayon : \n");
        scanf("%f", &rayon);
        
        /* calcul du périmètre */
        perimetre = 2 * PI * rayon;
        /* formule pour avoir le plus grand périmètre */
        if (perimetre > plusGrandCercle)
          plusGrandCercle = perimetre;
        /* calcul de la surface */
        surface = PI * rayon * rayon;

        /* affichage des résultats */
        printf("\n=========================\n");
        printf("Figure : cercle\nRayon : %6.2f cm\nPérimètre : %6.2f cm\nSurface : %6.2f cm²", rayon, perimetre, surface);
        printf("\n=========================\n");
      break;
      case 'R':
        /* nombre total des rectangles traités */
        nbRectangle++;

        printf("Entrez la mesure de la longueur, puis celle de la largeur : \n");
        scanf("%f%f", &longueur, &largeur);

        /* calcul du périmètre */
        perimetre = 2 * (longueur + largeur);
        /* calcul de la surface */
        surface = longueur * largeur;
        /* formule pour avoir la somme des surfaces */
        somSurface += surface;
        /* formule pour avoir la plus grande surface */
        if (surface > plusGrandRectangle)
          plusGrandRectangle = surface;

        /* affichage des résultats */
        printf("\n=========================\n");
        printf("Figure : rectangle\nLongueur : %6.2f cm\nLargeur : %6.2f cm\nPérimètre : %6.2f cm\nSurface : %6.2f cm²", longueur, largeur, perimetre, surface);
        printf("\n=========================\n");
      break;
      case 'K':
        printf("Entrez la mesure d'un côté : \n");
        scanf("%f", &cote);
        /* formule pour avoir la plus petit côté */
        if (cote < plusPetitCarre)
          plusPetitCarre = cote;

        /* calcul du périmètre */
        perimetre = 4 * cote;
        /* calcul de la surface */
        surface = cote * cote;

        /* affichage des résultats */
        printf("\n=========================\n");
        printf("Figure : carré\nCôté : %6.2f cm\nPérimètre : %6.2f cm\nSurface : %6.2f cm²", cote, perimetre, surface);
        printf("\n=========================\n");
      break;
    }
    
    /* demande pour continuer le programme */
    printf("\nVoulez-vous continuer ? (o/n)\n");
    fflush(stdin);
    scanf(" %c", &choix);

  /* réponse à la demande */
  } while (choix == 'o' || choix == 'O');

  /* affichage sommaire des résultats */
  printf("\nBilan : \n");
  printf("La surface moyenne des rectangles traités est %6.2f cm²;\n", somSurface / nbRectangle);
  printf("Le périmètre le plus grand des cercles traités est %6.2f cm;\n", plusGrandCercle);
  printf("La surface la plus grande des rectangles traités est %6.2f cm;\n", plusGrandRectangle);
  printf("Le côté le plus petit des carrés traités est %6.2f cm.\n", plusPetitCarre);

  return 0;
}

/* EXÉCUTION

Saisissez la forme géométrique à traiter (C pour un cercle, R pourrectangle ou K pour un carré) : 
c
Entrez la mesure du rayon :
5.7

=========================
Figure : cercle
Rayon :   5.70 cm
Périmètre :  35.81 cm
Surface : 102.07 cm²
=========================

Voulez-vous continuer ? (o/n)
o

Saisissez la forme géométrique à traiter (C pour un cercle, R pourrectangle ou K pour un carré) :
k
Entrez la mesure d'un côté :
3.9

=========================
Figure : carré
Côté :   3.90 cm
Périmètre :  15.60 cm
Surface :  15.21 cm²
=========================

Voulez-vous continuer ? (o/n)
o

Saisissez la forme géométrique à traiter (C pour un cercle, R pourrectangle ou K pour un carré) : 
r
Entrez la mesure de la longueur, puis celle de la largeur :
9.2
6.8

=========================
Figure : rectangle
Longueur :   9.20 cm
Largeur :   6.80 cm
Périmètre :  32.00 cm
Surface :  62.56 cm²
=========================

Voulez-vous continuer ? (o/n)
o

Saisissez la forme géométrique à traiter (C pour un cercle, R pourrectangle ou K pour un carré) : 
c
Entrez la mesure du rayon :
9.3

=========================
Figure : cercle
Rayon :   9.30 cm
Périmètre :  58.43 cm
Surface : 271.72 cm²
=========================

Voulez-vous continuer ? (o/n)
o

Saisissez la forme géométrique à traiter (C pour un cercle, R pourrectangle ou K pour un carré) : 
r
Entrez la mesure de la longueur, puis celle de la largeur :
5.7
3.8

=========================
Figure : rectangle
Longueur :   5.70 cm
Largeur :   3.80 cm
Périmètre :  19.00 cm
Surface :  21.66 cm²
=========================

Voulez-vous continuer ? (o/n)
o

Saisissez la forme géométrique à traiter (C pour un cercle, R pourrectangle ou K pour un carré) : 
c
Entrez la mesure du rayon :
3.5

=========================
Figure : cercle
Rayon :   3.50 cm
Périmètre :  21.99 cm
Surface :  38.48 cm²
=========================

Voulez-vous continuer ? (o/n)
o

Saisissez la forme géométrique à traiter (C pour un cercle, R pourrectangle ou K pour un carré) : 
k
Entrez la mesure d'un côté :
10.5

=========================
Figure : carré
Côté :  10.50 cm
Périmètre :  42.00 cm
Surface : 110.25 cm²
=========================

Voulez-vous continuer ? (o/n)
n

Bilan :
La surface moyenne des rectangles traités est  42.11 cm²;
Le périmètre le plus grand des cercles traités est  58.43 cm;
La surface la plus grande des rectangles traités est  62.56 cm;
Le côté le plus petit des carrés traités est   3.90 cm.

*/