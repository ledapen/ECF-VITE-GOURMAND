<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Vite & Gourmand</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Application de commande de menus événementiels à Bordeaux.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-success" href="/">Vite & Gourmand</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navMain" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="/menus">Menus</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="btn btn-success ms-lg-2" href="/login">Connexion</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/user/orders">Mes commandes</a></li><li class="nav-item"><a class="nav-link" href="/user/profile">Mon profil</a></li>
                    <?php if ($_SESSION['user']['role'] === 'employe'): ?>
                        <li class="nav-item"><a class="nav-link" href="/employee/dashboard">Espace employé</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION['user']['role'] === 'administrateur'): ?>
                        <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Administration</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="/logout">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-4">
<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>
