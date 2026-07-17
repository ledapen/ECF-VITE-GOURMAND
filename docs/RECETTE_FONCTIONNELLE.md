# Recette fonctionnelle finale

## Parcours visiteur
- Accueil accessible.
- Menus accessibles sans connexion.
- Filtres dynamiques AJAX.
- Détail menu accessible.
- Contact enregistré en base et notification mail.

## Parcours utilisateur
- Création de compte avec mot de passe fort.
- Connexion.
- Réinitialisation du mot de passe.
- Commande d'un menu.
- Annulation tant que la commande est en attente.
- Consultation de l'historique.
- Modification du profil.
- Avis possible après commande terminée.

## Parcours employé
- Tableau de bord employé.
- Création/modification/désactivation de menus.
- Upload d'image menu.
- Gestion des plats.
- Gestion des horaires.
- Gestion des commandes.
- Mise à jour des statuts avec historique.
- Validation/refus des avis.
- Traitement des demandes de contact.

## Parcours administrateur
- Accès au tableau de bord.
- Création/désactivation des employés.
- Statistiques chiffre d'affaires par menu.
- Graphique de comparaison.

## Tests exécutables
Lancer :

```bash
make test
```

ou :

```bash
php tests/security_test.php
php tests/business_rules_test.php
```
