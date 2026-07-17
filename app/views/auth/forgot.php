<h1>Mot de passe oublié</h1>
<form method="post" action="/password/forgot" class="card p-4">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <div class="mb-3">
        <label for="email" class="form-label">Adresse mail</label>
        <input id="email" name="email" type="email" class="form-control" required>
    </div>
    <button class="btn btn-success">Recevoir un lien</button>
</form>
