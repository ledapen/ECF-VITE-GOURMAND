<h1>Modifier un menu</h1>
<form method="post" action="/employee/menu-update" class="card p-4" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <input type="hidden" name="id_menu" value="<?= (int)$menu['id_menu'] ?>">
    <div class="mb-3"><label class="form-label">Titre</label><input name="titre" class="form-control" value="<?= Security::e($menu['titre']) ?>" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" required><?= Security::e($menu['description']) ?></textarea></div>
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Thème ID</label><input name="id_theme" type="number" class="form-control" value="<?= (int)$menu['id_theme'] ?>" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Régime ID</label><input name="id_regime" type="number" class="form-control" value="<?= (int)$menu['id_regime'] ?>" required></div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3"><label class="form-label">Personnes minimum</label><input name="nb_personnes_min" type="number" class="form-control" value="<?= (int)$menu['nb_personnes_min'] ?>" required></div>
        <div class="col-md-4 mb-3"><label class="form-label">Prix minimum</label><input name="prix_minimum" type="number" step="0.01" class="form-control" value="<?= (float)$menu['prix_minimum'] ?>" required></div>
        <div class="col-md-4 mb-3"><label class="form-label">Stock</label><input name="stock_disponible" type="number" class="form-control" value="<?= (int)$menu['stock_disponible'] ?>" required></div>
    </div>
    <div class="mb-3"><label class="form-label">Conditions</label><textarea name="conditions_menu" class="form-control" required><?= Security::e($menu['conditions_menu']) ?></textarea></div>
    <div class="form-check mb-3"><input id="actif" class="form-check-input" type="checkbox" name="actif" <?= $menu['actif'] ? 'checked' : '' ?>><label for="actif" class="form-check-label">Menu actif</label></div>
    <div class="mb-3"><label class="form-label">Nouvelle image</label><input name="image" type="file" accept="image/png,image/jpeg,image/webp" class="form-control"></div>
    <button class="btn btn-success">Mettre à jour</button>
</form>
