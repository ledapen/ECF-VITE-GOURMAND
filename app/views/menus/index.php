<h1>Tous les menus</h1>

<form method="get" class="row g-3 card p-3 mb-4" id="menuFilters">
    <div class="col-md-3">
        <label class="form-label" for="prix_max">Prix maximum</label>
        <input id="prix_max" name="prix_max" type="number" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label" for="theme">Thème</label>
        <select id="theme" name="theme" class="form-select">
            <option value="">Tous</option>
            <option>Noel</option>
            <option>Paques</option>
            <option>Classique</option>
            <option>Evenement</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="regime">Régime</label>
        <select id="regime" name="regime" class="form-select">
            <option value="">Tous</option>
            <option>Classique</option>
            <option>Vegetarien</option>
            <option>Vegan</option>
            <option>Sans gluten</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label" for="personnes">Personnes</label>
        <input id="personnes" name="personnes" type="number" class="form-control">
    </div>
    <div class="col-12">
        <button class="btn btn-success">Filtrer</button>
    </div>
</form>

<div class="row" id="menusContainer">
<?php foreach ($menus as $menu): ?>
    <article class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5"><?= htmlspecialchars($menu['titre']) ?></h2>
                <p><?= htmlspecialchars($menu['description']) ?></p>
                <p><strong><?= number_format((float)$menu['prix_minimum'], 2, ',', ' ') ?> €</strong>
                pour <?= (int)$menu['nb_personnes_min'] ?> personnes minimum</p>
                <a class="btn btn-outline-success" href="/menu?id=<?= (int)$menu['id_menu'] ?>">Voir le détail</a>
            </div>
        </div>
    </article>
<?php endforeach; ?>
</div>
