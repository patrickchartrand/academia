/* 
  Travail pratique #1
  Auteur : Patrick Chartrand (20017273)
  Date : 13 février 2020
*/



/* PARTIE B */
#include <stdio.h>
#include <ctype.h>

int main(){

  char sexe, choix;
  int jour, mois, an;

  /* boucle afin de traiter plusieurs usagers */
  do{
    /* saisie de la donnée reliée au sexe */
    printf("\n\nSaisie de votre sexe\n");
    printf("====================\n");
    printf("Entrez la première lettre du sexe correspondant (masculin ou féminin) : \n");
    scanf(" %c", &sexe);
    /* saisie des données reliées à la date de naissance */
    printf("\n\nSaisie de votre date de naissance\n");
    printf("=================================\n");
    printf("Entrez le jour (JJ) : ");
    scanf("%d", &jour);
    printf("Entrez le mois (MM) : ");
    scanf("%d", &mois);
    printf("Entrez l'année (AAAA) : ");
    scanf("%d", &an);

    /* à savoir si le sexe saisie est masculin ou féminin */
    if (sexe == 'F' || sexe == 'f'){
      printf("\n\nC'est une femme née le ");
    } else if (sexe == 'M' || sexe == 'm'){
      printf("\n\nC'est un homme né le ");
    }

    /* association des mois à partir de leur valeur numérique entrée */
    switch(mois){
      case 1: printf("%d janvier %d", jour, an);
      break;
      case 2: printf("%d février %d", jour, an);
      break;
      case 3: printf("%d mars %d", jour, an);
      break;
      case 4: printf("%d avril %d", jour, an);
      break;
      case 5: printf("%d mai %d", jour, an);
      break;
      case 6: printf("%d juin %d", jour, an);
      break;
      case 7: printf("%d juillet %d", jour, an);
      break;
      case 8: printf("%d août %d", jour, an);
      break;
      case 9: printf("%d septembre %d", jour, an);
      break;
      case 10: printf("%d octobre %d", jour, an);
      break;
      case 11: printf("%d novembre %d", jour, an);
      break;
      case 12: printf("%d décembre %d", jour, an);
      break;
    }

    /* demande pour continuer le programme */
    printf("\n\n\nVoulez-vous continuer ? (o/n)\n");
    fflush(stdin);
    scanf(" %c", &choix);

  /* réponse à la demande */
  } while (choix == 'o' || choix == 'O');

  return 0;
}

/* EXÉCUTION

Saisie de votre sexe
====================
Entrez la première lettre du sexe correspondant (masculin ou féminin) : 
f


Saisie de votre date de naissance
=================================
Entrez le jour (JJ) : 19
Entrez le mois (MM) : 02
Entrez l'année (AAAA) : 1999


C'est une femme née le 19 février 1999


Voulez-vous continuer ? (o/n)
o


Saisie de votre sexe
====================
Entrez la première lettre du sexe correspondant (masculin ou féminin) : 
m


Saisie de votre date de naissance
=================================
Entrez le jour (JJ) : 03
Entrez le mois (MM) : 10
Entrez l'année (AAAA) : 2000


C'est un homme né le 3 octobre 2000


Voulez-vous continuer ? (o/n)
o


Saisie de votre sexe
====================
Entrez la première lettre du sexe correspondant (masculin ou féminin) : 
f


Saisie de votre date de naissance
=================================
Entrez le jour (JJ) : 24
Entrez le mois (MM) : 12
Entrez l'année (AAAA) : 2002


C'est une femme née le 24 décembre 2002


Voulez-vous continuer ? (o/n)
n

*/