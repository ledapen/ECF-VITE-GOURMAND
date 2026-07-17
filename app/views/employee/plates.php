<h1>Gestion des plats</h1>
<form method="post" action="/employee/plates/store" class="card p-4 mb-4">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <h2 class="h4">Ajouter un plat</h2>
    <div class="mb-3"><label class="form-label">Nom</label><input name="nom" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control"></textarea></div>
    <div class="mb-3">
        <label class="form-label">Type</label>
        <select name="type_plat" class="form-select">
            <option value="entree">Entrée</option>
            <option value="plat">Plat</option>
            <option value="dessert">Dessert</option>
        </select>
    </div>
    <button class="btn btn-success">Ajouter</button>
</form>

<table class="table table-striped">
<thead><tr><th>Nom</th><th>Type</th><th>Actif</th><th>Action</th></tr></thead>
<tbody>
<?php foreach ($plates as $plate): ?>
<tr>
    <td><?= Security::e($plate['nom']) ?></td>
    <td><?= Security::e($plate['type_plat']) ?></td>
    <td><?= $plate['actif'] ? 'Oui' : 'Non' ?></td>
    <td>
        <form method="post" action="/employee/plates/delete">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            <input type="hidden" name="id_plat" value="<?= (int)$plate['id_plat'] ?>">
            <button class="btn btn-sm btn-outline-danger">Désactiver</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
