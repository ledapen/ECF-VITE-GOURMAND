# ECF DWWM – Vite & Gourmand

Projet réalisé dans le cadre de l'ECF du titre professionnel Développeur Web et Web Mobile.

## Fonctionnalités principales

- Consultation des menus
- Filtres dynamiques
- Création de compte
- Connexion sécurisée
- Commande d'un menu
- Espace utilisateur
- Espace employé
- Espace administrateur
- Gestion des avis
- Statistiques MongoDB

## Stack technique

- Front-end : HTML5, CSS3, Bootstrap 5, JavaScript
- Back-end : PHP 8 orienté MVC
- Base relationnelle : MySQL / MariaDB
- Base NoSQL : MongoDB
- Accès aux données : PDO
- Versioning : Git / GitHub

## Installation locale

1. Cloner le dépôt.
2. Importer `database/mysql/vite_gourmand_schema_data.sql`.
3. Copier `.env.example` vers `.env`.
4. Modifier les identifiants de base de données.
5. Lancer le serveur PHP :

```bash
php -S localhost:8000 -t public
```

6. Accéder à l'application :

```text
http://localhost:8000
```

## Comptes de test

- Administrateur : admin@vitegourmand.fr
- Employé : employe@vitegourmand.fr
- Utilisateur : alice.martin@example.fr

Mot de passe de démonstration à définir dans la base avec `password_hash()`.


## Lancement rapide

### Windows

Double-cliquer sur :

```text
run-local.bat
```

### Linux / macOS

```bash
chmod +x run-local.sh
./run-local.sh
```

### Tests

```bash
make test
```

ou :

```bash
php tests/security_test.php
php tests/business_rules_test.php
```

## Parcours livrés

- Visiteur : accueil, menus, filtres AJAX, détail, contact.
- Utilisateur : inscription, connexion, mot de passe oublié, commande, annulation, profil, avis.
- Employé : menus, plats, horaires, commandes, avis, contacts.
- Administrateur : employés, statistiques, graphique.

## Important

Avant présentation officielle :
- importer le fichier SQL ;
- créer de vrais mots de passe hashés ;
- configurer les variables `.env` ;
- tester l'application sur l'hébergement final ;
- renseigner dans la copie à rendre le lien GitHub, le lien de déploiement et le lien Trello/Notion.
