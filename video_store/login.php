<?php
session_start();
require_once "inc/db.php";
require_once "inc/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(["email" => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["pseudo"] = $user["pseudo"];
        echo "<p>Connexion réussie.</p>";
        echo "<a href='index.php'>Aller à l'accueil</a>";
    } else {
        echo "<p>Identifiants incorrects.</p>";
    }
}
?>

<h1>Connexion</h1>
<form method="POST">
    <label>Email :</label><br>
    <input type="email" name="email"><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password"><br><br>

    <input type="submit" value="Se connecter">
</form>

<?php require_once "inc/footer.php"; ?>
