////////////////////////////////////////////
//  Travail pratique #2                   //
//  Auteur : Patrick Chartrand (20017273) //
//  Date : 9 mars 2020                    //
////////////////////////////////////////////


// PARTIE B
#include <stdio.h>

int main()
{

  char poste[8] = { 'P', 'P', 'O', 'A', 'P', 'A', 'P', 'P' };
  int cafe[8] = {  3 ,  1 ,  6 ,  0 ,  5 ,  4 ,  0 ,  3  };
  int age[8] = { 25 , 19 , 27 , 26 , 69 , 24 , 56 , 29  };
 
  int nbPers = sizeof(age) / sizeof(int),
    // variable pour les boucles for et le tri
    i,
    j, 
    indMin,
    // variables temporaires
    tempoAge,
    tempoCafe, 
    tempoPoste;


  // AFFICHAGE DU TABLEAU 1
  // titre
  printf("Tableau 1 :\npostes, consommations de café et âges\n");
  printf("===========================================================\n");
  // données par poste
  printf("| Postes |");     
  for (i = 0; i < nbPers ; i++)
  printf("|  %c  ", poste[i]);
  printf("|\n");
  printf("-----------------------------------------------------------\n");      

  // données par quantité de café
  printf("| Cafés  |");     
  for (i = 0; i < nbPers ; i++)
  printf("|  %d  ", cafe[i]);
  printf("|\n");
  printf("-----------------------------------------------------------\n");      

  // données par âges
  printf("|  Âges  |");     
  for (i = 0; i < nbPers ; i++)
  printf("|  %d ", age[i]);
  printf("|\n");
  printf("===========================================================\n\n\n");      


  // CALCULS À PARTIR DES DONNÉES DU TABLEAU 1
  // calcul du nombre total de programmeurs
  j = 0;
  for (i = 0; i < nbPers; i++)
  {
    if (poste[i] == 'P') j++;
  }
  printf("Nombre de programmeurs : %d\n", j);

  // calcul du nombre total de secrétaires
  j = 0;
  for (i = 0; i < nbPers; i++) 
  {
    if (poste[i] == 'S') j++;
  }
  printf("Nombre de secrétaires : %d\n", j);

  // calcul de la plus petite consommation de café
  j = 100;
  for (i = 0; i < nbPers; i++)
  {
    if (poste[i] == 'A' && cafe[i] < j)
    j = cafe[i];
  }
  printf("Nombre minimale de consommation en café par analyste : %d\n", j);

  // calcul du plus grand âge parmi les analystes
  j = 0;
  for (i = 0; i < nbPers; i++)
  {
    if (poste[i] == 'P' && age[i] > j)
    j = age[i];
  }
  printf("Plus grand âge parmi tous les programmeurs : %d\n", j);

  // calcul de la consommation moyenne de café par les programmeurs
  j = 0;
  for (i = 0; i < nbPers; i++)
  if (poste[i] == 'O')
  {
    j += cafe[i];
  }
  printf("Moyenne de la consommation en café chez les opérateurs : %0.2f\n", ((float)j / nbPers));

  // calcul de l'âge moyen de tous les employés
  j = 0;
  for (i = 0; i < nbPers; i++)
  {
    j += age[i];
  }
  printf("Moyenne d'âge parmi tous les employés : %0.2f ans\n\n\n", ((float)j / nbPers));
 

  // TRI DES DONNÉES DU TABLEAU 1
  // Le tri par âge
  for (i = 0; i < nbPers - 1; i++)
  {
    indMin = i;
    for (j = i + 1; j < nbPers; j++)
    if (age[j] < age[indMin])
    indMin = j;
    if (indMin != i)
    {
      tempoAge = age[i];
      age[i] = age[indMin];
      age[indMin] = tempoAge;
          
      tempoCafe = cafe[i];
      cafe[i] = cafe[indMin];
      cafe[indMin] = tempoCafe;

      tempoPoste = poste[i];
      poste[i] = poste[indMin];
      poste[indMin] = tempoPoste;
    }      
  }


  // AFFICHAGE DU TABLEAU 2
  // titre
  printf("Tableau 2 :\npostes, consommations de café par ordre croissant d'âges\n");   
  printf("===========================================================\n");
  // données par poste    
  printf("| Postes |");
  for (i = 0; i < nbPers ; i++)
  printf("|  %c  ", poste[i]);
  printf("|\n");
  printf("-----------------------------------------------------------\n");      

  // données par quantité de café
  printf("| Cafés  |");     
  for (i = 0; i < nbPers ; i++)
  printf("|  %d  ", cafe[i]);
  printf("|\n");
  printf("-----------------------------------------------------------\n");      

  // données par âges
  printf("|  Âges  |");     
  for (i = 0; i < nbPers ; i++)
  printf("|  %d ", age[i]);
  printf("|\n");
  printf("===========================================================\n\n\n");


  return 0;

}

/* EXÉCUTION

Tableau 1 :
postes, consommations de café et âges
===========================================================
| Postes ||  P  |  P  |  O  |  A  |  P  |  A  |  P  |  P  |
-----------------------------------------------------------
| Cafés  ||  3  |  1  |  6  |  0  |  5  |  4  |  0  |  3  |
-----------------------------------------------------------
|  Âges  ||  25 |  19 |  27 |  26 |  69 |  24 |  56 |  29 |
===========================================================


Nombre de programmeurs : 5
Nombre de secrétaires : 0
Nombre minimale de consommation en café par analyste : 0
Plus grand âge parmi tous les programmeurs : 69
Moyenne de la consommation en café chez les opérateurs : 0.75
Moyenne d'âge parmi tous les employés : 34.38 ans


Tableau 2 :
postes, consommations de café par ordre croissant d'âges
===========================================================
| Postes ||  P  |  A  |  P  |  A  |  O  |  P  |  P  |  P  |
-----------------------------------------------------------
| Cafés  ||  1  |  4  |  3  |  0  |  6  |  3  |  0  |  5  |
-----------------------------------------------------------
|  Âges  ||  19 |  24 |  25 |  26 |  27 |  29 |  56 |  69 |
===========================================================

*/
