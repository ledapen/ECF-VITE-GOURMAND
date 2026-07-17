<h1>Créer un menu</h1>
<form method="post" action="/employee/menu-store" class="card p-4" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <div class="mb-3"><label class="form-label">Titre</label><input name="titre" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" required></textarea></div>
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Thème</label><input name="id_theme" type="number" class="form-control" value="1" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Régime</label><input name="id_regime" type="number" class="form-control" value="1" required></div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3"><label class="form-label">Personnes minimum</label><input name="nb_personnes_min" type="number" class="form-control" required></div>
        <div class="col-md-4 mb-3"><label class="form-label">Prix minimum</label><input name="prix_minimum" type="number" step="0.01" class="form-control" required></div>
        <div class="col-md-4 mb-3"><label class="form-label">Stock</label><input name="stock_disponible" type="number" class="form-control" required></div>
    </div>
    <div class="mb-3"><label class="form-label">Conditions</label><textarea name="conditions_menu" class="form-control" required></textarea></div>
    <div class="mb-3"><label class="form-label">Image</label><input name="image" type="file" accept="image/png,image/jpeg,image/webp" class="form-control"></div>
    <button class="btn btn-success">Enregistrer</button>
</form>
