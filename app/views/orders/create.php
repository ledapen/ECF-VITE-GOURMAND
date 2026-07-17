<h1>Commander : <?= htmlspecialchars($menu['titre']) ?></h1>
<form method="post" action="/orders/store" class="card p-4">
    <input type="hidden" name="id_menu" value="<?= (int)$menu['id_menu'] ?>">

    <div class="mb-3">
        <label class="form-label" for="date_prestation">Date de la prestation</label>
        <input id="date_prestation" name="date_prestation" type="date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="heure_livraison">Heure de livraison</label>
        <input id="heure_livraison" name="heure_livraison" type="time" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="adresse_livraison">Adresse de livraison</label>
        <input id="adresse_livraison" name="adresse_livraison" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="ville_livraison">Ville de livraison</label>
        <input id="ville_livraison" name="ville_livraison" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="nb_personnes">Nombre de personnes</label>
        <input id="nb_personnes" name="nb_personnes" type="number" class="form-control"
               min="<?= (int)$menu['nb_personnes_min'] ?>" required>
        <small>Minimum : <?= (int)$menu['nb_personnes_min'] ?> personnes.</small>
    </div>

    <button class="btn btn-success">Valider la commande</button>
</form>
