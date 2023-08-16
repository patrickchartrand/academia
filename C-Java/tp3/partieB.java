////////////////////////////////////////////
//  Travail pratique #3                   //
//  Auteur : Patrick Chartrand (20017273) //
//  Date : 23 avril 2020                  //
////////////////////////////////////////////

// PARTIE B
public class partieB {

    // fonction pour afficher le tableau
    static void afficher(char[] poste, double[] cafe, double[] age, int nbEmp)
    {
        String messageAv = "avant le triage";
        // message d'avant tri
        System.out.printf("Tableau 1 :\n%s\n", messageAv);
        System.out.printf("====================\n");
        System.out.printf("poste || cafe || age\n");
        System.out.printf("====================\n");
        // répartition des données
	    for(int i = 0; i < nbEmp; i++)
	    System.out.printf("  %c   ||  %.0f   ||  %.0f\n", poste[i], cafe[i], age[i]);
        System.out.printf("====================\n\n");
    }
    
    // fonction pour les calculs
    static int combien(char posteChoisi, char[] poste, int nbEmp)
    {
        int n = 0;
        for(int i = 0; i < nbEmp; i++)
        if (poste[i] == posteChoisi)
            n++;
        
        return n;
    }
    
    // fonction pour les moyennes
    static double moyenne(double[] tab, int nbElem)
    {
        double somme = 0.0;

        for(int i = 0; i < nbElem; i++)
        somme += tab[i];
   	    
   	    return somme / nbElem;
    }
    
    // fonction pour le triage
    static void trier(char poste[], double cafe[], double age[], int nbEmp)
    {
        int indMin, i, j;
        // variables temporaires
        double tempoAge, tempoCafe;
        char tempoPoste;
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
            String messageAp = "après le triage (par ordre croissant d'âges)";
            // message d'après tri
            System.out.printf("Tableau 2 :\n%s\n", messageAp);
            System.out.printf("====================\n");
            System.out.printf("poste || cafe || age\n");
            System.out.printf("====================\n");
            // répartition des données
    	    for(i = 0; i < nbEmp; i++)
    	    System.out.printf("  %c   ||  %.0f   ||  %.0f\n", poste[i], cafe[i], age[i]);
            System.out.printf("====================\n\n");
        }

    // espace principal
    public static void main(String[] args)
    {
        // les données du tableau
        char poste[] = { 'P', 'P', 'O', 'A', 'P', 'A', 'P', 'P' };
        double [] cafe = {  3 ,  1 ,  6 ,  0 ,  5 ,  4 ,  0 ,  3  }, age = { 25 , 19 , 27 , 26 , 69 , 24 , 56 , 29  };

        // longueur du tableau
        int nbEmp = poste.length;
        
        // retour de fonctions
	    afficher(poste, cafe, age, nbEmp);
	    trier(poste, cafe, age, nbEmp);
	    
        // affichage de fonctions retournées ici
        System.out.printf("Nombre de programmeurs : %d\n", combien('P', poste, nbEmp));
        System.out.printf("Nombre d'opérateurs : %d\n", combien('O', poste, nbEmp));
        System.out.printf("Nombre d'analystes : %d\n", combien('A', poste, nbEmp));
        System.out.printf("Nombre de secrétaires : %d\n", combien('S', poste, nbEmp));
        System.out.printf("Moyenne d'âge parmi tous les employés : %.2f ans\n", moyenne(age, nbEmp));
        System.out.printf("Moyenne de consommation en café parmi tous les employés : %.2f\n", moyenne(cafe, nbEmp));
    }
    
}


/* EXÉCUTION

Tableau 1 :
avant le triage
====================
poste || cafe || age
====================
  P   ||  3   ||  25
  P   ||  1   ||  19
  O   ||  6   ||  27
  A   ||  0   ||  26
  P   ||  5   ||  69
  A   ||  4   ||  24
  P   ||  0   ||  56
  P   ||  3   ||  29
====================

Tableau 2 :
après le triage (par ordre croissant d'âges)
====================
poste || cafe || age
====================
  P   ||  1   ||  19
  A   ||  4   ||  24
  P   ||  3   ||  25
  A   ||  0   ||  26
  O   ||  6   ||  27
  P   ||  3   ||  29
  P   ||  0   ||  56
  P   ||  5   ||  69
====================

Nombre de programmeurs : 5
Nombre d'opérateurs : 1
Nombre d'analystes : 2
Nombre de secrétaires : 0
Moyenne d'âge parmi tous les employés : 34.38 ans
Moyenne de consommation en café parmi tous les employés : 2.75

*/