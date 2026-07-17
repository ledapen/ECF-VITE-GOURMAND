<div class="d-flex justify-content-between align-items-center">
    <h1>Gestion des menus</h1>
    <a class="btn btn-success" href="/employee/menu-create">Créer un menu</a>
</div>
<table class="table table-striped">
    <thead><tr><th>Titre</th><th>Thème</th><th>Régime</th><th>Prix</th><th>Stock</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach ($menus as $menu): ?>
        <tr>
            <td><?= Security::e($menu['titre']) ?></td>
            <td><?= Security::e($menu['theme']) ?></td>
            <td><?= Security::e($menu['regime']) ?></td>
            <td><?= number_format((float)$menu['prix_minimum'], 2, ',', ' ') ?> €</td>
            <td><?= (int)$menu['stock_disponible'] ?></td>
            <td class="d-flex gap-2">
                <a class="btn btn-sm btn-outline-success" href="/employee/menu-edit?id=<?= (int)$menu['id_menu'] ?>">Modifier</a>
                <form method="post" action="/employee/menu-delete">
                    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                    <input type="hidden" name="id_menu" value="<?= (int)$menu['id_menu'] ?>">
                    <button class="btn btn-sm btn-outline-danger">Désactiver</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
