<?php
require_once "inc/db.php";
require_once "inc/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pseudo = $_POST["pseudo"];
    $password = $_POST["password"];

    if (!empty($email) && !empty($pseudo) && !empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (email, pseudo, password) VALUES (:email, :pseudo, :password)");
        $stmt->execute([
            "email" => $email,
            "pseudo" => $pseudo,
            "password" => $hash
        ]);

        echo "<p>Inscription réussie !</p>";
    } else {
        echo "<p>Veuillez remplir tous les champs.</p>";
    }
}
?>

<h1>Inscription</h1>
<form method="POST">
    <label>Email :</label><br>
    <input type="email" name="email"><br><br>

    <label>Pseudo :</label><br>
    <input type="text" name="pseudo"><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password"><br><br>

    <input type="submit" value="S'inscrire">
</form>

<?php require_once "inc/footer.php"; ?>
