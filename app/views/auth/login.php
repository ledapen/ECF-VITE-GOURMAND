<h1>Connexion</h1>
<form method="post" action="/login" class="card p-4">
    <div class="mb-3">
        <label for="email" class="form-label">Adresse mail</label>
        <input id="email" name="email" type="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input id="password" name="password" type="password" class="form-control" required>
    </div>
    <button class="btn btn-success">Se connecter</button>
    <a href="/register" class="mt-3 d-inline-block">Créer un compte</a><br><a href="/password/forgot">Mot de passe oublié ?</a>
</form>
