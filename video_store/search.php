<?php
require_once "inc/db.php";
require_once "inc/header.php";

// Vérifie que la requête GET est bien présente
if (isset($_GET["q"])) {
    $q = trim($_GET["q"]);

    $stmt = $pdo->prepare("
        SELECT videos.*
        FROM videos
        LEFT JOIN directors ON videos.director_id = directors.id
        WHERE videos.title LIKE :query OR directors.name LIKE :query
        ORDER BY videos.title ASC
    ");
    $stmt->execute(["query" => "%" . $q . "%"]);
    $results = $stmt->fetchAll();
} else {
    $results = [];
}
?>

<h1>Résultats de recherche</h1>

<form method="GET">
    <label>Recherche :</label>
    <input type="text" name="q" required>
    <input type="submit" value="Rechercher">
</form>

<?php if (isset($_GET["q"])): ?>
    <h2>Résultats pour : "<?= htmlspecialchars($q) ?>"</h2>

    <?php if (count($results) === 0): ?>
        <p>Aucun résultat trouvé.</p>
    <?php else: ?>
        <?php foreach ($results as $video): ?>
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
    <?php endif; ?>
<?php endif; ?>

<?php require_once "inc/footer.php"; ?>
