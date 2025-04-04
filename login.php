<?php
session_start();

// Hårdkodat lösenord (byt detta till något säkrare!)
$correct_password = "bralösen";
$ok=true;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["password"]) && $_POST["password"] === $correct_password) {
        $_SESSION["loggedin"] = true;
        header("Location: index.php");
        exit;
    } else {
        $ok=false;
    }
}?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login for Docx</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php require "menu.php"; ?>
    <!-- Notifieringsruta (bör vara på alla sidor) -->

    <h1>Logga in</h1>
    <form action="login.php" method="post">
        <input type="password" name="password" placeholder="Lösenord" required>
        <button type="submit">Logga in</button>
    </form>
    <script src="js/script.js"></script>
</body>
</html>
<?php if($ok==false){ echo "<script>showNotification('Fel lösenord!', 'error');</script>";} ?>

