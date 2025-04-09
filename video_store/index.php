<?php
require_once "inc/db.php";
require_once "inc/header.php";

// Récupérer les 4 dernières vidéos ajoutées
$videos = $pdo->query("SELECT * FROM videos ORDER BY id DESC LIMIT 4")->fetchAll();
?>

<p>Bienvenue sur le site. Vous pouvez rechercher des films ou parcourir les dernières vidéos ajoutées.</p>

<!-- Formulaire de recherche -->
<form method="GET" action="search.php">
    <label>Recherche par titre ou réalisateur :</label><br>
    <input type="text" name="q" required>
    <input type="submit" value="Rechercher">
</form>

<h2>Dernières vidéos</h2>

<?php foreach ($videos as $video): ?>
    <div>
        <p><strong>Titre :</strong> <?= htmlspecialchars($video["title"]) ?></p>
        <p><strong>Prix :</strong> <?= number_format($video["price"], 2) ?> €</p>

        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="video_id" value="<?= $video["id"] ?>">
            <input type="submit" value="Ajouter au panier">
        </form>
    </div>
    <hr>
<?php endforeach; ?>

<?php
require_once "inc/footer.php";
?>
