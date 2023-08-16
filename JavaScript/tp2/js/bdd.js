var tabPatients = [
    {
        "Dossier": 1,
        "Nom": "Léger",
        "Prénom": "Émile",
        "Naissance": "26 mars 1917",
        "Sexe": "M"
    },
    {
        "Dossier": 2,
        "Nom": "Bernard",
        "Prénom": "Marie",
        "Naissance": "3 février 1946",
        "Sexe": "F"
    },
    {
        "Dossier": 3,
        "Nom": "Chartrand",
        "Prénom": "Guy",
        "Naissance": "5 avril 1959",
        "Sexe": "M"
    },
    {
        "Dossier": 4,
        "Nom": "Côté",
        "Prénom": "André",
        "Naissance": "2 septembre 1978",
        "Sexe": "M"
    },
    {
        "Dossier": 5,
        "Nom": "Lavoie",
        "Prénom": "Carole",
        "Naissance": "4 novembre 1973",
        "Sexe": "F"
    },
    {
        "Dossier": 6,
        "Nom": "Martin",
        "Prénom": "Diane",
        "Naissance": "2 décembre 1965",
        "Sexe": "F"
    },
    {
        "Dossier": 7,
        "Nom": "Lacroix",
        "Prénom": "Pauline",
        "Naissance": "25 janvier 1956",
        "Sexe": "F"
    },
    {
        "Dossier": 8,
        "Nom": "St-Jean",
        "Prénom": "Arthur",
        "Naissance": "7 octobre 1912",
        "Sexe": "M"
    },
    {
        "Dossier": 9,
        "Nom": "Béchard",
        "Prénom": "Marc",
        "Naissance": "8 août 1980",
        "Sexe": "M"
    },
    {
        "Dossier": 10,
        "Nom": "Chartrand",
        "Prénom": "Mario",
        "Naissance": "23 juillet 1947",
        "Sexe": "M"
    }
];

var tabEtablissements = [
    {
        "Établissement": 1234,
        "Nom": "Centre hospitalier Sud",
        "Adresse": "1234 boul. Sud, Montréal, Qc",
        "Code postal": "H2M 3Y6",
        "Téléphone": "(514)123-1234"
    },
    {
        "Établissement": 2346,
        "Nom": "Hôpital Nord",
        "Adresse": "7562 rue du Souvenir, Nordville, Qc",
        "Code postal": "J4R 2Z5",
        "Téléphone": "(450)222-3333"
    },
    {
        "Établissement": 3980,
        "Nom": "Hôpital Centre",
        "Adresse": "4637 boul. de l'Église, Montréal, Qc",
        "Code postal": "H3J 4K8",
        "Téléphone": "(514)123-5678"
    },
    {
        "Établissement": 4177,
        "Nom": "Centre hospitalier Est",
        "Adresse": "12 rue Bernard, Repentigny, Qc",
        "Code postal": "J8R 3K5",
        "Téléphone": "(450)589-2345"
    },
    {
        "Établissement": 7306,
        "Nom": "Hôpital du salut",
        "Adresse": "11 rue de la Rédemption, St-Basile, Qc",
        "Code postal": "J8H 2D4",
        "Téléphone": "(450)345-6789"
    },
    {
        "Établissement": 8895,
        "Nom": "Dernier recours",
        "Adresse": "999 rue St-Pierre, Longueuil, Qc",
        "Code postal": "J7B 3J5",
        "Téléphone": "(450)555-6741"
    }
];

var tabHospitalisations = [
    {
        "Code établissement": 1234,
        "No dossier patient": 5,
        "Date admission": "14-août-00",
        "Date sortie": "14-août-01",
        "Spécialité": "médecine"
    },
    {
        "Code établissement": 1234,
        "No dossier patient": 10,
        "Date admission": "12-déc.-92",
        "Date sortie": "12-déc.-92",
        "Spécialité": "chirurgie"
    },
    {
        "Code établissement": 2346,
        "No dossier patient": 8,
        "Date admission": "03-mars-03",
        "Date sortie": "05-mars-03",
        "Spécialité": "médecine"
    },
    {
        "Code établissement": 2346,
        "No dossier patient": 3,
        "Date admission": "12-avr.-95",
        "Date sortie": "30-avr.-95",
        "Spécialité": "médecine"
    },
    {
        "Code établissement": 2346,
        "No dossier patient": 1,
        "Date admission": "11-nov.-97",
        "Date sortie": "12-nov.-97",
        "Spécialité": "orthopédie"
    },
    {
        "Code établissement": 3980,
        "No dossier patient": 5,
        "Date admission": "14-févr.-00",
        "Date sortie": "14-mars-00",
        "Spécialité": "médecine"
    },
    {
        "Code établissement": 3980,
        "No dossier patient": 5,
        "Date admission": "01-janv.-01",
        "Date sortie": "01-févr.-01",
        "Spécialité": "médecine"
    },
    {
        "Code établissement": 3980,
        "No dossier patient": 9,
        "Date admission": "03-avr.-95",
        "Date sortie": "08-avr.-95",
        "Spécialité": "orthopédie"
    },
    {
        "Code établissement": 3980,
        "No dossier patient": 7,
        "Date admission": "27-nov.-99",
        "Date sortie": "04-déc.-99",
        "Spécialité": "chirurgie"
    },
    {
        "Code établissement": 3980,
        "No dossier patient": 10,
        "Date admission": "28-avr.-97",
        "Date sortie": "05-mai-97",
        "Spécialité": "chirurgie"
    },
    {
        "Code établissement": 4177,
        "No dossier patient": 3,
        "Date admission": "03-août-01",
        "Date sortie": "05-déc.-01",
        "Spécialité": "médecine"
    },
    {
        "Code établissement": 4177,
        "No dossier patient": 3,
        "Date admission": "02-févr.-02",
        "Date sortie": "23-févr.-02",
        "Spécialité": "orthopédie"
    },
    {
        "Code établissement": 7306,
        "No dossier patient": 2,
        "Date admission": "23-mai-98",
        "Date sortie": "27-mai-98",
        "Spécialité": "orthopédie"
    }
];