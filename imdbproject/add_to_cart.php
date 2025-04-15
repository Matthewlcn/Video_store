<?php
session_start();
require_once "inc/db.php";

if (!isset($_SESSION["user_id"])) {
    die("Vous devez être connecté pour ajouter au panier.");
}

if (!isset($_POST["video_id"])) {
    die("ID vidéo manquant.");
}

$video_id = (int) $_POST["video_id"];
$user_id = $_SESSION["user_id"];


$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id AND video_id = :video_id");
$stmt->execute([
    "user_id" => $user_id,
    "video_id" => $video_id
]);

if ($stmt->rowCount() === 0) {
    $stmt = $pdo->prepare("INSERT INTO cart (user_id, video_id) VALUES (:user_id, :video_id)");
    $stmt->execute([
        "user_id" => $user_id,
        "video_id" => $video_id
    ]);
}

header("Location: cart.php");
exit;
