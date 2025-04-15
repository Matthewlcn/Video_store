<?php
require_once "inc/db.php";
require_once "inc/header.php";


$videos = $pdo->query("SELECT * FROM videos ORDER BY id DESC")->fetchAll();
?>

<div class="intro-grid">
  <div class="welcome">
      <h1>Bienvenue sur IMDB & Co</h1>
      <p>Explorez nos dernières vidéos, recherchez vos réalisateurs favoris et composez votre collection !</p>
  </div>

  <div class="search-box right">
      <form method="GET" action="search.php">
          <label for="q">🔍 Recherche par titre ou réalisateur :</label>
          <input type="text" name="q" id="q" placeholder="Ex. Iron Man, Nolan..." required>
          <input type="submit" value="Rechercher">
      </form>
  </div>
</div>

<h2 class="video-section-title">🎞️ Dernières vidéos</h2>

<div class="videos-flex">
  <?php foreach ($videos as $video): ?>
    <div class="video-preview-card">

      <?php if (!empty($video["image"])): ?>
        <img src="images/<?= htmlspecialchars($video["image"]) ?>" alt="<?= htmlspecialchars($video["title"]) ?>" class="video-card-image">
      <?php endif; ?>

      <h3><?= htmlspecialchars($video['title']) ?></h3>
      <p><strong>Prix :</strong> <?= number_format($video["price"], 2) ?> €</p>

      <form method="POST" action="add_to_cart.php">
        <input type="hidden" name="video_id" value="<?= $video["id"] ?>">
        <input type="submit" value="Ajouter au panier">
      </form>

      <a href="video.php?id=<?= $video['id'] ?>" class="video-link">📄 Voir la fiche</a>
    </div>
  <?php endforeach; ?>
</div>


<?php require_once "inc/footer.php"; ?>
