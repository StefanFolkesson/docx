<?php
require_once('functions.php');
session_start();
checkLogin();
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <p>Välkommen! Här kan du redigera filer.</p>
    <ul>
        <li><a href="index.php">📄 Visa instruktioner</a></li>
        <li><a href="upload.php">⬆️ Ladda upp Markdown-fil</a></li>
        <li><a href="logout.php">🚪 Logga ut</a></li>
    </ul>
</body>
</html>
