////////////////////////////////////////////
//  Travail pratique #3                   //
//  Auteur : Patrick Chartrand (20017273) //
//  Date : 23 avril 2020                  //
////////////////////////////////////////////

// PARTIE C
class Employe
{
    // champs privés : numéro d'assurance social et salaire hebdomadaire
    private String NAS;
    private double salHebdo;

    // un constructeur
    public Employe(String num, double sH)
    {
        NAS = num;
        salHebdo = sH;
    }

    // méthode d'équation
    public Employe(String num, double temps, double salaire)
    {
        NAS = num;
        salHebdo = temps * salaire;
    }

    // méthode d'accès
    public double getCalcul()
    {
        return salHebdo;
    }
  
    // affichage d'informations
    public void afficher(String message)
    {
        System.out.printf("%s :\n   - numéro d'assurance social : %s\n   - salaire hebdomadaire : %.2f$ par semaine\n", message, NAS, salHebdo);
    }
    
    // affichage d'une fiche
    public void ficheDuMeilleurSalaire(String message, int indMax)
    {
        System.out.printf("%s :\n   - indice : %d)\n   - numéro d'assurance social : %s\n   - salaire hebdomadaire : %.2f$ par semaine\n", message, indMax, NAS, salHebdo);
    }

    // méthode de modification
    public void setCalcul(double nouvCalcul)
    {
        salHebdo = nouvCalcul;
    }
    
    // une autre méthode d'accès
    public String getNAS()
    {
        return NAS;
    }
}

public class numC_tp3_h20 
{
    // on affiche le contenu du tableau
    static void afficher(Employe[] emp, int nbEmp)
    {
        System.out.printf("\n\nTableau des employés par salaire hebdomaire :\nIndice       NAS        Salaire hebdo.\n", nbEmp);
        for(int i = 0; i < nbEmp; i++)
            System.out.printf("%2d)      %s      %8.2f\n", i, emp[i].getNAS(),
            emp[i].getCalcul());
            System.out.printf("\n\n");
    }
    
    // on détermine le salaire maximal
    static void maxi(Employe[] emp, int nbEmp)
    {
        int indMax = 0;
        for(int i = 0; i < nbEmp; i++)
            if (emp[i].getCalcul() > emp[indMax].getCalcul())
                indMax = i;
            // on retourne la valeur d'indice
            emp[indMax].ficheDuMeilleurSalaire("Fiche du meilleur salaire hebdomadaire", indMax);
    }

    public static void main(String[] args) 
    {
        // introduction de deux employés
        Employe emp1 = new Employe("321 498 726", 987.50),
        emp2 = new Employe("135 444 321", 45.00, 20.00);

        // affichage
        emp2.afficher("Informations du second employé");

        // ajout d'un montant au salaire de l'employé
        emp1.setCalcul(emp2.getCalcul() + 123.25);
        emp1.afficher("Informations du premier employé après modification");
        
        // tableau des employés
        Employe[] emp = { new Employe("321 498 726", 1234.50),
                          new Employe("250 412 555", 2348.25),
                          new Employe("450 250 765", 1085.00),
                          new Employe("987 654 321", 45, 25.75),
                          new Employe("321 498 250", 42.50, 34.25) };
        int nbEmp = emp.length;
      
        // affichages dans le « main »
        numC_tp3_h20.afficher(emp, nbEmp);
        maxi(emp, nbEmp);
    }
}


/* EXÉCUTION

Informations du second employé :
   - numéro d'assurance social : 135 444 321
   - salaire hebdomadaire : 900.00$ par semaine
Informations du premier employé après modification :
   - numéro d'assurance social : 321 498 726
   - salaire hebdomadaire : 1023.25$ par semaine


Tableau des employés par salaire hebdomaire :
Indice       NAS        Salaire hebdo.
 0)      321 498 726       1234.50
 1)      250 412 555       2348.25
 2)      450 250 765       1085.00
 3)      987 654 321       1158.75
 4)      321 498 250       1455.63


Fiche du meilleur salaire hebdomadaire :
   - indice : 1)
   - numéro d'assurance social : 250 412 555
   - salaire hebdomadaire : 2348.25$ par semaine

*/