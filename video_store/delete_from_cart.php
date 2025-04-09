<?php
session_start();

if (isset($_POST["clear"])) {
    // Vider tout le panier
    $_SESSION["cart"] = [];
    header("Location: cart.php");
    exit;
}

if (!isset($_POST["video_id"])) {
    die("ID vidéo manquant.");
}

$video_id = (int) $_POST["video_id"];

// Retirer la vidéo du panier si elle existe
if (isset($_SESSION["cart"])) {
    $index = array_search($video_id, $_SESSION["cart"]);
    if ($index !== false) {
        unset($_SESSION["cart"][$index]);
        $_SESSION["cart"] = array_values($_SESSION["cart"]); // réindexer
    }
}

header("Location: cart.php");
exit;
