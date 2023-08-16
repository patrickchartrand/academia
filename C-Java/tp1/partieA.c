/* 
	Travail pratique #1
	Auteur : Patrick Chartrand (20017273)
	Date : 13 février 2020
*/



/* PARTIE A */
#include <stdio.h>

int main(){

  /* 1 mile = 1.609444 kilomètre */
  const float MI_EN_KM = 1.609444;
  /* 1 livre = 0.454 kilogramme */
  const float LB_EN_KG = 0.454;
  /* la distance en mile */
  int distanceMi, poidsLb;
  /* la distance en kilomètre */
  float distanceKm, poidsKg;

    /* saisie des données */
    printf("Saisissez un nombre entier correspondant à la distance parcourue en mile : ");
    scanf("%d", &distanceMi);
    printf("Saisissez un nombre entier correspondant au poids en livre : ");
    scanf("%d", &poidsLb);

    /* conversion d'une donnée de mile en kilomètre */
    distanceKm = distanceMi * MI_EN_KM;
    /* conversion d'une donnée de livre en kilogramme */
    poidsKg = poidsLb * LB_EN_KG;

    /* affichage des résultats */
    printf("\n");
    printf("La distance parcourue est de %d mile(s) et de %3.2f kilomètre(s).", distanceMi, distanceKm);
    printf("\n");
    printf("Le poids est de %d livre(s) et de %3.2f kilogramme(s).", poidsLb, poidsKg);

    return 0;
}

/* EXÉCUTION

Saisissez un nombre entier correspondant à la distance parcourue en mile : 30
Saisissez un nombre entier correspondant au poids en livre : 150

La distance parcourue est de 30 miles et de 48.28 kilomètre(s).
Le poids est de 150 livres et de 68.10 kilogramme(s).

*/