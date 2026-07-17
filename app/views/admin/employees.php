<h1>Gestion des employés</h1>
<form method="post" action="/admin/employees/store" class="card p-4 mb-4">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <h2 class="h4">Créer un employé</h2>
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Nom</label><input name="nom" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label class="form-label">Prénom</label><input name="prenom" class="form-control" required></div>
    </div>
    <div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Mot de passe temporaire</label><input name="password" type="password" class="form-control" required></div>
    <button class="btn btn-success">Créer le compte</button>
</form>

<table class="table table-striped">
<thead><tr><th>Employé</th><th>Email</th><th>Actif</th><th>Action</th></tr></thead>
<tbody>
<?php foreach ($employees as $employee): ?>
<tr>
    <td><?= Security::e($employee['prenom'] . ' ' . $employee['nom']) ?></td>
    <td><?= Security::e($employee['email']) ?></td>
    <td><?= $employee['actif'] ? 'Oui' : 'Non' ?></td>
    <td>
        <form method="post" action="/admin/employees/toggle">
            <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
            <input type="hidden" name="id_utilisateur" value="<?= (int)$employee['id_utilisateur'] ?>">
            <button class="btn btn-sm btn-outline-danger">Activer / désactiver</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
