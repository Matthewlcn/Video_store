<?php
session_start();

if (!isset($_POST["video_id"])) {
    die("ID vidéo manquant.");
}

$video_id = (int) $_POST["video_id"];

// Crée le panier s'il n'existe pas
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Ajouter l'ID de la vidéo au panier
$_SESSION["cart"][] = $video_id;

// Redirige vers la page précédente
header("Location: cart.php");
exit;
