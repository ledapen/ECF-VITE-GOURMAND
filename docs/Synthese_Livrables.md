# Synthèse des livrables ECF

## Documents réalisés

- Présentation du projet
- Analyse fonctionnelle
- Cahier des charges
- Diagrammes UML
- MCD
- MLD
- Script SQL
- Charte graphique
- Gestion de projet
- Documentation technique
- Manuel utilisateur
- Documentation de déploiement
- Plan de tests

## Projet source

Le projet suit une architecture MVC PHP avec :
- `public/` : point d'entrée et assets
- `app/controllers/` : contrôleurs
- `app/models/` : accès aux données
- `app/views/` : vues
- `app/core/` : routeur, sécurité, base de données
- `database/` : SQL et exemples MongoDB

## Parcours disponibles

- Visiteur : accueil, menus, détail, contact
- Utilisateur : inscription, connexion, commande, suivi, avis
- Employé : gestion menus, commandes, avis
- Administrateur : employés, statistiques
