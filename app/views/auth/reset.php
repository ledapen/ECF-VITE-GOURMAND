<h1>Réinitialiser le mot de passe</h1>
<form method="post" action="/password/reset" class="card p-4">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <input type="hidden" name="email" value="<?= Security::e($_GET['email'] ?? '') ?>">
    <input type="hidden" name="token" value="<?= Security::e($_GET['token'] ?? '') ?>">
    <div class="mb-3">
        <label for="password" class="form-label">Nouveau mot de passe</label>
        <input id="password" name="password" type="password" class="form-control" required>
        <small>10 caractères minimum, une majuscule, une minuscule, un chiffre et un caractère spécial.</small>
    </div>
    <button class="btn btn-success">Modifier le mot de passe</button>
</form>
