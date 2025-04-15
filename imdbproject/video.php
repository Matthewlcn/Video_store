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
    INNER JOIN video_actor ON actors.id = video_actor.actor_id
    WHERE video_actor.video_id = :id
");
$stmtActors->execute(["id" => $id]);
$actors = $stmtActors->fetchAll();
?>

<div class="video-details-wrapper">
  <div class="video-image">
    <img src="images/<?= htmlspecialchars($video["image"]) ?>" alt="<?= htmlspecialchars($video["title"]) ?>">
  </div>

  <div class="video-info-card">
    <h2>Détails de la vidéo</h2>
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
    <p><strong>Description :</strong> <?= htmlspecialchars($video["description"]) ?></p>

    <form method="POST" action="add_to_cart.php">
      <input type="hidden" name="video_id" value="<?= $video["id"] ?>">
      <input type="submit" value="Ajouter au panier">
    </form>
  </div>
</div>


<?php require_once "inc/footer.php"; ?>
