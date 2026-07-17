# Organisation Git

## Branches

- `main` : version stable et livrable.
- `develop` : intégration des fonctionnalités.
- `feature/authentification`
- `feature/menus`
- `feature/commandes`
- `feature/admin`
- `feature/deploiement`

## Exemple de commandes

```bash
git checkout -b develop
git checkout -b feature/authentification
git add .
git commit -m "feat: add user authentication"
git checkout develop
git merge feature/authentification
git checkout main
git merge develop
```
