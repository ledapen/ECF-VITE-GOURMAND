<h1>Mon profil</h1>
<form method="post" action="/user/profile-update" class="card p-4">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Nom</label><input name="nom" class="form-control" value="<?= Security::e($user['nom']) ?>" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Prénom</label><input name="prenom" class="form-control" value="<?= Security::e($user['prenom']) ?>" required></div>
    </div>
    <div class="mb-3"><label class="form-label">Téléphone</label><input name="telephone" class="form-control" value="<?= Security::e($user['telephone']) ?>" required></div>
    <div class="mb-3"><label class="form-label">Adresse</label><input name="adresse" class="form-control" value="<?= Security::e($user['adresse']) ?>" required></div>
    <button class="btn btn-success">Mettre à jour</button>
</form>
