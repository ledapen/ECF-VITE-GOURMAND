<h1>Contact</h1>
<form method="post" action="/contact" class="card p-4">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input id="titre" name="titre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Adresse mail</label>
        <input id="email" name="email" type="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Message</label>
        <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
    </div>
    <button class="btn btn-success">Envoyer</button>
</form>
