<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Internet Movies DB</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/buttons.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/video.css">    
    <link rel="stylesheet" href="css/cart.css">      
    <link rel="stylesheet" href="css/profile.css">    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="page-wrapper">

<header>
    <div class="nav-container">
        <div class="nav-left">
            <h1 class="site-title"><a href="index.php">🎬 IMDB & Co</a></h1>
            <a href="index.php" class="btn-nav">Accueil</a>
            <a href="cart.php" class="btn-nav">🛒 Voir le panier</a>
        </div>

        <div class="nav-right">
            <?php if (isset($_SESSION["user_id"])): ?>
                <a href="profile.php" class="btn-nav btn-pseudo">👤 <?= htmlspecialchars($_SESSION["pseudo"] ?? 'Profil') ?></a>
                <a href="logout.php" class="btn-nav">Se déconnecter</a>
            <?php else: ?>
                <a href="login.php" class="btn-nav">Se connecter</a>
                <a href="register.php" class="btn-nav">Créer un compte</a>
            <?php endif; ?>
        </div>
    </div>
</header>
