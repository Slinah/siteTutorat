# Refonte Tutorat - Cahier des charges

## Refonte du site [ScratchOverflow](https://scratchoverflow.fr/)

Ce projet à pour but de reprendre le site du tutorat existant afin de le porter sur [Symfony](https://symfony.com/) et d'y ajouter des fonctionnalitées.

## Fonctionnalitées

> ### **Fonctionnalitées globales**
>[color=#AFF99A]

- Connexion
- Création de compte

    >*Specs utilisateurs*
    >- Nom
    >- Prenom
    >- Mail
    >- Mot de passe
    >- Classe
    >- Image de profil
    >[color=orange]

- Création de cours

    >*Specs cours*
    >- Intitule
    >- Heure
    >- Date
    >- Matiere
    >[color=orange]

- Création de proposition

    >*Specs proposition*
    >- Matiere(s)
    >- Niveau(x)
    >[color=orange]

- Ajout de matières (Après validation par un administrateur)
    
    >*Specs matiere*
    >- Intitule
    >[color=orange]

- Liste des cours persos à venir pour les tuteurs
    - Possibilité de **modification**
    - Possibilité d'**annulation**
    - Possibilité de **clore** un de ses cours

    >*Specs fin de cours*
    >- Nombre participants
    >- Nombre d'heure
    >- Commentaires
    >[color=orange]
    
- Possibilité d'être tuteur d'un cours proposé par sois même
- Possibilité de s'ajouter des "tags" de matières avec différents niveaux
    >*Specs tags*
    >- A besoin d'aide
    >- A l'aise
    >- Expert
    >[color=orange]

- Possibilité de créer un sujet dans le forum
    >*Specs forum*
    >- Question
    >- Message
    >- Matière
    >[color=orange]

- Possibilité de poster un message dans le forum
- Possibilité de modifier un de ses message dans le forum
- Possibilité de trier les personnes par tags de compétences, et avoir accès a leur mail
- Avoir un système de notification
    Exemple : `Si je possède le tag "A besoin d'aide en PHP, je reçois une notification par mail de la création d'un cours de PHP."`
- Possibilité de "voter" pour une proposition
- Possibilité d'enlever son vote pour une proposition
- Possibilité de s'inscrire a un cours
- Possibilité de se désinscrire d'un cours
- Possibilité de voir et modifier ses informations persos ( :warning: RGPD )
---
> ### **Fonctionnalitées admins**
>[color=#AFF99A]

- Possibilité de suppression de propositions
- Pannel admin
    - Liste des personnes enregistrées
            - Possibilité de **suppression**
            - Possibilité de **modification**

    - Liste des matières
            - Possibilité de **suppression**
            - Possibilité de **modification**
    - Liste des cours
            - Possibilité de **suppression**
            - Possibilité de **modification**
            - Possibilité d'**annulation**
            - Possibilité de **clore** un cours
 
 - Visualisation de stats
    - Pour chaque promo
    >- Participants - Inscrits par cours
    >- Matières en pourcentage de participations
    >- Heures par matières
    >[color=violet]

    - Global
    >- Récap des tuteurs, leurs heures, matières
    >- Graphs récap des stats des années passées fonction de l'année présente
    >[color=violet]
    - Export de ces stats en PDF

- Administration du forum
    - Cloture de sujet
    - Suppression de sujet
    - Suppression de message

##    Base de données
