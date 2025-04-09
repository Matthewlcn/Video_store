<?php
session_start();
require_once "inc/db.php";
require_once "inc/header.php";

if (!isset($_SESSION["user_id"])) {
    die("Accès refusé. Veuillez vous connecter.");
}

$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("
    SELECT videos.title, videos.price
    FROM purchases
    JOIN videos ON purchases.video_id = videos.id
    WHERE purchases.user_id = :user_id
");
$stmt->execute(["user_id" => $user_id]);
$purchases = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["new_password"])) {
    $newPassword = $_POST["new_password"];

    if (!empty($newPassword)) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE users SET password = :pw WHERE id = :id");
        $stmt->execute(["pw" => $hashed, "id" => $user_id]);

        echo "<p>Mot de passe mis à jour.</p>";
    } else {
        echo "<p>Veuillez entrer un nouveau mot de passe.</p>";
    }
}
?>

<h1>Mon profil</h1>
<p>Connecté en tant que <strong><?= htmlspecialchars($_SESSION["pseudo"]) ?></strong></p>

<h2>Vidéos achetées</h2>

<?php if (count($purchases) === 0): ?>
    <p>Aucune vidéo achetée pour le moment.</p>
<?php else: ?>
    <ul>
        <?php foreach ($purchases as $video): ?>
            <li><?= htmlspecialchars($video["title"]) ?> – <?= number_format($video["price"], 2) ?> €</li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h2>Changer de mot de passe</h2>
<form method="POST">
    <label>Nouveau mot de passe :</label><br>
    <input type="password" name="new_password"><br><br>
    <input type="submit" value="Mettre à jour">
</form>

<p><a href="logout.php">Se déconnecter</a></p>

<?php require_once "inc/footer.php"; ?>
