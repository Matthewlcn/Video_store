<?php
session_start();
require_once "inc/db.php";

if (!isset($_SESSION["user_id"])) {
    die("Vous devez être connecté pour modifier le panier.");
}

$user_id = $_SESSION["user_id"];

if (isset($_POST["video_id"])) {
    $video_id = (int) $_POST["video_id"];
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id AND video_id = :video_id");
    $stmt->execute([
        "user_id" => $user_id,
        "video_id" => $video_id
    ]);
}

if (isset($_POST["clear"])) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->execute(["user_id" => $user_id]);
}

// Retour au panier
header("Location: cart.php");
exit;
