<?php
require_once "inc/db.php";
require_once "inc/header.php";

if (!isset($_GET["type"])) {
    die("Catégorie manquante.");
}

$type = $_GET["type"];

if ($type !== "action" && $type !== "drama") {
    die("Catégorie non valide.");
}

$stmt = $pdo->prepare("SELECT * FROM videos WHERE category = :type ORDER BY title ASC");
$stmt->execute(["type" => $type]);
$videos = $stmt->fetchAll();
?>

<h1>Films de la catégorie : <?= htmlspecialchars(ucfirst($type)) ?></h1>

<?php if (count($videos) === 0): ?>
    <p>Aucun film trouvé dans cette catégorie.</p>
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
