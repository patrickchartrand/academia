////////////////////////////////////////////
//  Travail pratique #2                   //
//  Auteur : Patrick Chartrand (20017273) //
//  Date : 9 mars 2020                    //
////////////////////////////////////////////


// PARTIE A
#include <stdio.h>

int main()
{
  
  int total1, depart, fin, valeur;
  float total2, diviseur;


  // AVEC BOUCLE WHILE
  printf("Calcul avec la boucle 'while' :\n");
  // initialisation des variables
  total1 = 0;
  depart = 20;
  fin = 130;
  valeur = depart;
  // boucle while
  while(valeur <= fin)
  { 
    total1 += valeur;
    valeur += 10;
  }
  // affichage de la réponse
  printf("- Somme 1 : %d\n", total1);
  
  // initialisation des variables
  total1 = 0;
  depart = 20;
  fin = 1280;
  valeur = depart;
  // boucle while
  while(valeur <= fin)
  { 
    total1 += valeur;
    valeur *= 2;
  }
  // affichage de la réponse
  printf("- Somme 2 : %d\n\n", total1); 


  // AVEC BOUCLE DO...WHILE
  printf("Calcul avec la boucle 'do...while' :\n");
  // initialisation des variables
  total2 = 0;
  depart = 5;
  fin = 19;
  diviseur = depart;
  // boucle do...while
  do
  { 
    total2 += 1 / diviseur;
    diviseur += 2;
  } while(diviseur <= fin);
  // affichage de la réponse
  printf("- Somme 3 : %f\n", total2);
  
  // initialisation des variables
  total1 = 0;
  depart = 1;
  fin = 99;
  valeur = depart;
  // boucle do...while
  do
  { 
    total1 += valeur;
    valeur += 2;
  } while(valeur <= fin);  
  // affichage de la réponse
  printf("- Somme 4 : %d\n\n", total1);


  // AVEC BOUCLE FOR
  printf("Calcul avec la boucle 'for' :\n");
  // initialisation des variables
  total1 = 0;
  depart = 20;
  fin = 130;
  // boucle for
  for(valeur = depart; valeur <= fin ; valeur += 10)
  total1 += valeur;
  // affichage de la réponse
  printf("- Somme 1 : %d\n", total1);

  // initialisation des variables
  total2 = 0;
  depart = 5;
  fin = 19;
  // boucle for
  for(diviseur = depart; diviseur <= fin ; diviseur += 2)
    total2 += 1 / diviseur;
  // affichage de la réponse
  printf("- Somme 3 : %f\n", total2);

  return 0;

}

/* EXÉCUTION

Calcul avec la boucle 'while' :
- Somme 1 : 900
- Somme 2 : 2540

Calcul avec la boucle 'do...while' :
- Somme 3 : 0.799922
- Somme 4 : 2500

Calcul avec la boucle 'for' :
- Somme 1 : 900
- Somme 3 : 0.799922

*/