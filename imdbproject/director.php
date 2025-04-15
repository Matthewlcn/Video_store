<?php
require_once "inc/db.php";
require_once "inc/header.php";

if (!isset($_GET["id"])) {
    die("Aucun réalisateur sélectionné.");
}

$id = (int) $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM directors WHERE id = :id");
$stmt->execute(["id" => $id]);
$director = $stmt->fetch();

if (!$director) {
    die("Réalisateur introuvable.");
}

$stmt = $pdo->prepare("SELECT * FROM videos WHERE director_id = :id ORDER BY title ASC");
$stmt->execute(["id" => $id]);
$videos = $stmt->fetchAll();
?>

<h1>Films réalisés par <?= htmlspecialchars($director["name"]) ?></h1>

<?php if (count($videos) === 0): ?>
    <p>Aucun film trouvé pour ce réalisateur.</p>
<?php else: ?>
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
<?php endif; ?>

<?php require_once "inc/footer.php"; ?>
