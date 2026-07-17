<h1>Créer un compte</h1>
<form method="post" action="/register" class="card p-4">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input id="nom" name="nom" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input id="prenom" name="prenom" class="form-control" required>
        </div>
    </div>
    <div class="mb-3">
        <label for="telephone" class="form-label">GSM</label>
        <input id="telephone" name="telephone" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse postale</label>
        <input id="adresse" name="adresse" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Adresse mail</label>
        <input id="email" name="email" type="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe sécurisé</label>
        <input id="password" name="password" type="password" class="form-control" required>
        <small>10 caractères minimum, une majuscule, une minuscule, un chiffre et un caractère spécial.</small>
    </div>
    <button class="btn btn-success">Créer mon compte</button>
</form>
