<?php
session_start();
require_once "inc/db.php";
require_once "inc/header.php";

if (!isset($_SESSION["user_id"])) {
    die("<p>Veuillez vous connecter pour voir votre panier.</p>");
}

$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("
    SELECT videos.*
    FROM videos
    JOIN cart ON cart.video_id = videos.id
    WHERE cart.user_id = :user_id
");
$stmt->execute(["user_id" => $user_id]);
$videos = $stmt->fetchAll();

if (count($videos) === 0) {
    echo "<h1>Panier</h1>";
    echo "<p>Votre panier est vide.</p>";
    require_once "inc/footer.php";
    exit;
}

$total = 0;
foreach ($videos as $video) {
    $total += $video["price"];
}
?>

<h1>Contenu du panier</h1>

<?php foreach ($videos as $video): ?>
    <div class="container">
        <p><strong>Titre :</strong> <?= htmlspecialchars($video["title"]) ?></p>
        <p><strong>Prix :</strong> <?= number_format($video["price"], 2) ?> €</p>

        <form method="POST" action="delete_from_cart.php">
            <input type="hidden" name="video_id" value="<?= $video["id"] ?>">
            <input type="submit" value="Supprimer" class="btn-nav">
        </form>
    </div>
    <hr>
<?php endforeach; ?>

<h3 style="text-align: center;">Total : <?= number_format($total, 2) ?> €</h3>

<div style="text-align: center;">
    <form method="POST" action="delete_from_cart.php">
        <input type="hidden" name="clear" value="1">
        <input type="submit" value="🗑️ Vider le panier" class="btn-nav">
    </form>
</div>

<?php require_once "inc/footer.php"; ?>
