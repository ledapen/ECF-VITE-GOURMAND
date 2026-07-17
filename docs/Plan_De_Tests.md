# Plan de tests – Vite & Gourmand

## Tests fonctionnels

| ID | Scénario | Résultat attendu |
|---|---|---|
| T01 | Création d'un compte avec mot de passe valide | Compte créé, mail de bienvenue envoyé |
| T02 | Création d'un compte avec mot de passe faible | Message d'erreur |
| T03 | Connexion avec identifiants corrects | Redirection accueil |
| T04 | Filtrage des menus par prix | Liste mise à jour sans rechargement |
| T05 | Commande inférieure au minimum | Commande refusée |
| T06 | Commande avec +5 personnes | Réduction de 10 % |
| T07 | Employé change le statut | Historique mis à jour |
| T08 | Client dépose un avis | Avis en attente de validation |
| T09 | Employé valide un avis | Avis visible |
| T10 | Admin désactive un employé | Compte inutilisable |

## Tests de sécurité

- Injection SQL dans les formulaires.
- Injection XSS dans les commentaires.
- Accès direct aux routes employé sans rôle.
- Modification d'un formulaire sans jeton CSRF.
- Vérification du stockage des mots de passe hashés.

## Tests RGAA

- Navigation au clavier.
- Contraste des boutons.
- Présence des labels de formulaire.
- Textes alternatifs des images.
- Structure HTML sémantique.
