<?php
session_start();
require_once "inc/db.php";
require_once "inc/header.php";

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

$cart = $_SESSION["cart"];

if (count($cart) === 0) {
    echo "<h1>Panier</h1>";
    echo "<p>Votre panier est vide.</p>";
    require_once "inc/footer.php";
    exit;
}

$placeholders = implode(',', array_fill(0, count($cart), '?'));
$stmt = $pdo->prepare("SELECT * FROM videos WHERE id IN ($placeholders)");
$stmt->execute($cart);
$videos = $stmt->fetchAll();

$total = 0;
foreach ($videos as $video) {
    $total += $video["price"];
}
?>

<h1>Contenu du panier</h1>

<?php foreach ($videos as $video): ?>
    <div>
        <p><strong>Titre :</strong> <?= htmlspecialchars($video["title"]) ?></p>
        <p><strong>Prix :</strong> <?= number_format($video["price"], 2) ?> €</p>
        <form method="POST" action="delete_from_cart.php">
            <input type="hidden" name="video_id" value="<?= $video["id"] ?>">
            <input type="submit" value="Supprimer">
        </form>
    </div>
    <hr>
<?php endforeach; ?>

<h3>Total : <?= number_format($total, 2) ?> €</h3>

<form method="POST" action="delete_from_cart.php">
    <input type="hidden" name="clear" value="1">
    <input type="submit" value="Vider le panier">
</form>

<?php require_once "inc/footer.php"; ?>
