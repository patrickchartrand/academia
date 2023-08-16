////////////////////////////////////////////
//  Travail pratique #3                   //
//  Auteur : Patrick Chartrand (20017273) //
//  Date : 23 avril 2020                  //
////////////////////////////////////////////

// PARTIE A
#include <stdio.h>

// fonction pour afficher le tableau
void afficher(char poste[], int cafe[], int age[], int nbEmp, char message[])
{
  // message d'avant tri
  printf("Tableau 1 :\n%s\n", message);
  printf("=====================\n");
  printf("poste || cafe || age\n");
  printf("=====================\n");
  // répartition des données
  for (int i = 0; i < nbEmp; i++)
  {
    printf("  %c   || %2d   ||  %2d\n", poste[i], cafe[i], age[i]);
  }
  printf("=====================\n\n");  
}

// fonction pour les nombres par poste
int nombre(char posteChoisi, char poste[], int nbEmp)
{
  int n = 0;
  for(int i = 0; i < nbEmp; i++)
    if (poste[i] == posteChoisi)
    n++;
    
  return  n;
}

// fonction pour les moyennes
float moyenne(int tableau[], int nbElem)
{
  float somme = 0.0;
    
  for(int i = 0; i < nbElem; i++)
    somme += tableau[i];
         
  return somme / nbElem;     
}

// fonction pour le triage
void trier(char poste[], int cafe[], int age[], int nbEmp, char message[])
{
  int indMin, i, j, 
      // variables temporaires
      tempoAge, tempoCafe, tempoPoste;
  // tri
  for (i = 0; i < nbEmp - 1; i++)
  {
    indMin = i;
    for (j = i + 1; j < nbEmp; j++)
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
  // message d'après tri
  printf("Tableau 2 :\n%s\n", message);
  printf("=====================\n");
  printf("poste || cafe || age\n");
  printf("=====================\n");
  // répartition des données
  for (i = 0; i < nbEmp; i++)
  {
    printf("  %c   || %2d   ||  %2d\n", poste[i], cafe[i], age[i]);
  }
  printf("=====================\n\n");
}

// espace principal
int main()
{
  // les données du tableau
  char poste[8] = { 'P', 'P', 'O', 'A', 'P', 'A', 'P', 'P' };
  int cafe[8] = {  3 ,  1 ,  6 ,  0 ,  5 ,  4 ,  0 ,  3  }, age[8] = { 25 , 19 , 27 , 26 , 69 , 24 , 56 , 29  };
  
  // longueur du tableau
  int nbEmp = sizeof(age) / sizeof(int);
    
  // retour de fonctions
  afficher(poste, cafe, age, nbEmp, "avant le triage");
  trier(poste, cafe, age, nbEmp, "après le triage (par ordre croissant d'âges)");

  // affichage de fonctions retournées ici
  printf("Nombre de programmeurs : %d\n", nombre('P', poste, nbEmp));
  printf("Nombre d'opérateurs : %d\n", nombre('O', poste, nbEmp));
  printf("Nombre d'analystes : %d\n", nombre('A', poste, nbEmp));
  printf("Nombre de secrétaires : %d\n", nombre('S', poste, nbEmp));
  printf("Moyenne d'âge parmi tous les employés : %.2f ans\n", moyenne(age, nbEmp));
  printf("Moyenne de consommation en café parmi tous les employés : %.2f\n", moyenne(cafe, nbEmp));
        
  return 0; 
}


/* EXÉCUTION

Tableau 1 :
avant le triage
=====================
poste || cafe || age
=====================
  P   ||  3   ||  25
  P   ||  1   ||  19
  O   ||  6   ||  27
  A   ||  0   ||  26
  P   ||  5   ||  69
  A   ||  4   ||  24
  P   ||  0   ||  56
  P   ||  3   ||  29
=====================

Tableau 2 :
après le triage (par ordre croissant d'âges)
=====================
poste || cafe || age
=====================
  P   ||  1   ||  19
  A   ||  4   ||  24
  P   ||  3   ||  25
  A   ||  0   ||  26
  O   ||  6   ||  27
  P   ||  3   ||  29
  P   ||  0   ||  56
  P   ||  5   ||  69
=====================

Nombre de programmeurs : 5
Nombre d'opérateurs : 1
Nombre d'analystes : 2
Nombre de secrétaires : 0
Moyenne d'âge parmi tous les employés : 34.38 ans
Moyenne de consommation en café parmi tous les employés : 2.75

*/