<h1>Gestion des commandes</h1>
<div class="table-responsive">
<table class="table table-striped">
<thead><tr><th>Client</th><th>Menu</th><th>Date</th><th>Statut</th><th>Action</th></tr></thead>
<tbody>
<?php foreach ($orders as $order): ?>
<tr>
    <td><?= Security::e($order['email']) ?></td>
    <td><?= Security::e($order['menu_titre']) ?></td>
    <td><?= Security::e($order['date_prestation']) ?></td>
    <td><?= Security::e($order['statut']) ?></td>
    <td>
        <form method="post" action="/employee/order-status" class="d-flex gap-2">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            <input type="hidden" name="id_commande" value="<?= (int)$order['id_commande'] ?>">
            <select name="id_statut" class="form-select form-select-sm">
                <?php foreach ($statuses as $status): ?>
                    <option value="<?= (int)$status['id_statut'] ?>"><?= Security::e($status['libelle']) ?></option>
                <?php endforeach; ?>
            </select>
            <input name="commentaire" class="form-control form-control-sm" placeholder="Commentaire">
            <button class="btn btn-sm btn-success">OK</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
