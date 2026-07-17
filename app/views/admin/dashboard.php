<h1>Tableau de bord administrateur</h1>
<a class="btn btn-outline-success mb-4" href="/admin/employees">Gérer les employés</a>

<h2>Chiffre d'affaires par menu</h2>
<table class="table table-striped">
<thead><tr><th>Menu</th><th>Commandes</th><th>Chiffre d'affaires</th></tr></thead>
<tbody>
<?php foreach ($stats as $row): ?>
<tr>
    <td><?= Security::e($row['titre']) ?></td>
    <td><?= (int)$row['nombre_commandes'] ?></td>
    <td><?= number_format((float)$row['chiffre_affaires'], 2, ',', ' ') ?> €</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<canvas id="caChart" height="120" aria-label="Graphique du chiffre d'affaires par menu"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
fetch('/admin/stats.json')
    .then(r => r.json())
    .then(rows => {
        new Chart(document.getElementById('caChart'), {
            type: 'bar',
            data: {
                labels: rows.map(r => r.titre),
                datasets: [{
                    label: "Chiffre d'affaires",
                    data: rows.map(r => Number(r.chiffre_affaires))
                }]
            }
        });
    });
</script>
