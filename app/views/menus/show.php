<article>
    <h1><?= htmlspecialchars($menu['titre']) ?></h1>
    <p class="badge bg-success"><?= htmlspecialchars($menu['theme']) ?></p>
    <p class="badge bg-secondary"><?= htmlspecialchars($menu['regime']) ?></p>

    <div class="card p-4 my-4">
        <h2>Description</h2>
        <p><?= htmlspecialchars($menu['description']) ?></p>

        <h2>Conditions importantes</h2>
        <div class="alert alert-warning">
            <?= nl2br(htmlspecialchars($menu['conditions_menu'])) ?>
        </div>

        <p><strong>Nombre minimum :</strong> <?= (int)$menu['nb_personnes_min'] ?> personnes</p>
        <p><strong>Prix minimum :</strong> <?= number_format((float)$menu['prix_minimum'], 2, ',', ' ') ?> €</p>
        <p><strong>Stock disponible :</strong> <?= (int)$menu['stock_disponible'] ?> commandes</p>

        <a class="btn btn-success btn-lg" href="/orders/create?menu_id=<?= (int)$menu['id_menu'] ?>">Commander</a>
    </div>
</article>
