<h1>Validation des avis</h1>
<table class="table table-striped">
<thead><tr><th>Client</th><th>Menu</th><th>Note</th><th>Commentaire</th><th>Visible</th><th>Action</th></tr></thead>
<tbody>
<?php foreach ($reviews as $review): ?>
<tr>
    <td><?= Security::e($review['email']) ?></td>
    <td><?= Security::e($review['menu_titre']) ?></td>
    <td><?= (int)$review['note'] ?>/5</td>
    <td><?= Security::e($review['commentaire']) ?></td>
    <td><?= $review['valide'] ? 'Oui' : 'Non' ?></td>
    <td>
        <form method="post" action="/employee/review-validate" class="d-flex gap-2">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            <input type="hidden" name="id_avis" value="<?= (int)$review['id_avis'] ?>">
            <button class="btn btn-sm btn-success" name="valide" value="1">Valider</button>
            <button class="btn btn-sm btn-outline-danger" name="valide" value="0">Refuser</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
