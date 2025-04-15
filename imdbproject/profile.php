<?php
session_start();
require_once "inc/db.php";
require_once "inc/header.php";

if (!isset($_SESSION["user_id"])) {
    die("Accès refusé. Veuillez vous connecter.");
}

$user_id = $_SESSION["user_id"];

// Récupération des vidéos achetées
$stmt = $pdo->prepare("
    SELECT videos.title, videos.price
    FROM purchases
    JOIN videos ON purchases.video_id = videos.id
    WHERE purchases.user_id = :user_id
");
$stmt->execute(["user_id" => $user_id]);
$purchases = $stmt->fetchAll();

// Gestion du changement de mot de passe
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["new_password"])) {
    $newPassword = $_POST["new_password"];

    if (!empty($newPassword)) {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = :pw WHERE id = :id");
        $stmt->execute(["pw" => $hashed, "id" => $user_id]);
        $message = "✅ Mot de passe mis à jour.";
    } else {
        $message = "⚠️ Veuillez entrer un nouveau mot de passe.";
    }
}
?>

<div class="profile-container">
    <div class="profile-card">
        <h2>👤 Mon profil</h2>
        <p>Connecté en tant que <strong><?= htmlspecialchars($_SESSION["pseudo"]) ?></strong></p>

        <?php if (isset($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <hr>

        <h3>🎥 Vidéos achetées</h3>
        <?php if (count($purchases) === 0): ?>
            <p><em>Aucune vidéo achetée pour le moment.</em></p>
        <?php else: ?>
            <ul class="purchase-list">
                <?php foreach ($purchases as $video): ?>
                    <li>
                        <?= htmlspecialchars($video["title"]) ?> — <?= number_format($video["price"], 2) ?> €
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <hr>

        <h3>Changer de mot de passe</h3>
        <form method="POST">
            <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
            <input type="submit" value="Mettre à jour">
        </form>

        <a href="logout.php" class="btn-logout">Se déconnecter</a>
    </div>
</div>

<?php require_once "inc/footer.php"; ?>