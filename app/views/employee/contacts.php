<h1>Demandes de contact</h1>
<table class="table table-striped">
<thead><tr><th>Date</th><th>Titre</th><th>Email</th><th>Message</th><th>Traité</th><th>Action</th></tr></thead>
<tbody>
<?php foreach ($contacts as $contact): ?>
<tr>
    <td><?= Security::e($contact['date_envoi']) ?></td>
    <td><?= Security::e($contact['titre']) ?></td>
    <td><?= Security::e($contact['email']) ?></td>
    <td><?= Security::e($contact['description']) ?></td>
    <td><?= $contact['traite'] ? 'Oui' : 'Non' ?></td>
    <td>
        <?php if (!$contact['traite']): ?>
        <form method="post" action="/employee/contact-treated">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            <input type="hidden" name="id_contact" value="<?= (int)$contact['id_contact'] ?>">
            <button class="btn btn-sm btn-success">Marquer traité</button>
        </form>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
