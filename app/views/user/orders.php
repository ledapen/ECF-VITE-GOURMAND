<h1>Mes commandes</h1>
<?php if (empty($orders)): ?>
    <p>Aucune commande pour le moment.</p>
<?php endif; ?>
<div class="table-responsive">
<table class="table table-striped">
    <thead><tr><th>Menu</th><th>Date</th><th>Statut</th><th>Total</th><th>Action</th><th>Avis</th></tr></thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= Security::e($order['menu_titre']) ?></td>
            <td><?= Security::e($order['date_prestation']) ?></td>
            <td><?= Security::e($order['statut']) ?></td>
            <td><?= number_format((float)$order['total'], 2, ',', ' ') ?> €</td>
            <td>
                <?php if ($order['statut'] === 'en attente'): ?>
                    <form method="post" action="/user/order-cancel">
                        <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                        <input type="hidden" name="id_commande" value="<?= (int)$order['id_commande'] ?>">
                        <button class="btn btn-sm btn-outline-danger">Annuler</button>
                    </form>
                <?php else: ?>-<?php endif; ?>
            </td>
            <td>
                <?php if ($order['statut'] === 'terminee'): ?>
                <form method="post" action="/user/review" class="d-flex gap-2">
                    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
                    <input type="hidden" name="id_commande" value="<?= (int)$order['id_commande'] ?>">
                    <select name="note" class="form-select form-select-sm">
                        <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    </select>
                    <input name="commentaire" class="form-control form-control-sm" placeholder="Votre avis">
                    <button class="btn btn-sm btn-success">Envoyer</button>
                </form>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
