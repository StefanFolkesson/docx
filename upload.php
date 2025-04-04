<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ladda upp Markdown</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "menu.php"; ?>
    
    
    <h3>Drag & Drop Files Here</h3>
    <div id="dropZone">Drop files here or click to select</div>
    <form type="multipart/form-data" id="uploadForm">
    <input type="file" id="fileInput" style="display: none;">
    </form>
    <!-- Jag skulle vilja skapa en fil i mitt system -->
    <input type="text" id="fileName" placeholder="Filnamn (utan .md)" required>
    <button id="uploadButton">Ladda upp</button>
    <textarea id="fileContent" placeholder="innehåll"></textarea>
    <ul id="uploadStatus"></ul>
    <script src="js/script.js"></script>
    <script src="js/ul.js"></script>
</body>
</html>
