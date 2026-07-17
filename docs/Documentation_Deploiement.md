# Documentation de déploiement

## Pré-requis

- PHP 8.2 minimum
- MySQL ou MariaDB
- MongoDB pour les statistiques
- Git
- Un hébergeur compatible PHP

## Déploiement local

```bash
cp .env.example .env
docker compose up -d
php -S localhost:8000 -t public
```

## Déploiement distant

1. Créer le dépôt GitHub public.
2. Pousser le code sur la branche `main`.
3. Créer la base MySQL distante.
4. Importer `database/mysql/vite_gourmand_schema_data.sql`.
5. Définir les variables d'environnement.
6. Configurer le document root sur `/public`.
7. Vérifier les droits d'écriture si des uploads sont ajoutés.
8. Tester les parcours : visiteur, utilisateur, employé, administrateur.

## Sécurité

- Ne jamais pousser le fichier `.env`.
- Forcer HTTPS.
- Activer les erreurs uniquement en environnement local.
- Utiliser `password_hash()` pour les mots de passe.
- Protéger les formulaires avec CSRF.
