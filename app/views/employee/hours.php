<h1>Gestion des horaires</h1>
<form method="post" action="/employee/hours/update" class="card p-4">
    <input type="hidden" name="csrf_token" value="<?= Security::csrfToken() ?>">
    <table class="table">
        <thead><tr><th>Jour</th><th>Ouverture</th><th>Fermeture</th><th>Fermé</th></tr></thead>
        <tbody>
        <?php foreach ($hours as $hour): ?>
        <tr>
            <td><?= Security::e($hour['jour_semaine']) ?></td>
            <td><input class="form-control" type="time" name="hours[<?= (int)$hour['id_horaire'] ?>][ouverture]" value="<?= Security::e($hour['heure_ouverture'] ?? '') ?>"></td>
            <td><input class="form-control" type="time" name="hours[<?= (int)$hour['id_horaire'] ?>][fermeture]" value="<?= Security::e($hour['heure_fermeture'] ?? '') ?>"></td>
            <td><input type="checkbox" name="hours[<?= (int)$hour['id_horaire'] ?>][ferme]" <?= $hour['ferme'] ? 'checked' : '' ?>></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <button class="btn btn-success">Enregistrer</button>
</form>
