<?php
require_once "inc/db.php";
require_once "inc/header.php";

if (!isset($_GET["id"])) {
    die("Aucune vidéo sélectionnée.");
}

$id = (int) $_GET["id"];

$stmt = $pdo->prepare("
    SELECT videos.*, directors.name AS director_name
    FROM videos
    LEFT JOIN directors ON videos.director_id = directors.id
    WHERE videos.id = :id
");
$stmt->execute(["id" => $id]);
$video = $stmt->fetch();

if (!$video) {
    die("Vidéo introuvable.");
}

$stmtActors = $pdo->prepare("
    SELECT actors.name
    FROM actors
    INNER JOIN video_actors ON actors.id = video_actors.actor_id
    WHERE video_actors.video_id = :id
");
$stmtActors->execute(["id" => $id]);
$actors = $stmtActors->fetchAll();
?>

<h1>Détails de la vidéo</h1>

<p><strong>Titre :</strong> <?= htmlspecialchars($video["title"]) ?></p>
<p><strong>Réalisateur :</strong>
    <a href="director.php?id=<?= $video["director_id"] ?>">
        <?= htmlspecialchars($video["director_name"]) ?>
    </a>
</p>

<p><strong>Acteurs :</strong><br>
    <?php foreach ($actors as $actor): ?>
        <?= htmlspecialchars($actor["name"]) ?><br>
    <?php endforeach; ?>
</p>

<p><strong>Prix :</strong> <?= number_format($video["price"], 2) ?> €</p>

<form method="POST" action="add_to_cart.php">
    <input type="hidden" name="video_id" value="<?= $video["id"] ?>">
    <input type="submit" value="Ajouter au panier">
</form>

<?php require_once "inc/footer.php"; ?>

