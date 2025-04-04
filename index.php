<?php
session_start();
require "functions.php";
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docx</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "menu.php"; 
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    $data = getSubjectsAndCategories();
    foreach ($data as $subject => $categories): ?>
        <div class="category" onclick="toggleCategory('<?= md5($subject) ?>')">
            <strong><?= htmlspecialchars($subject) ?></strong> ▼
        </div>
        <ul id="<?= md5($subject) ?>" class="file-list">
            <?php foreach ($categories as $category => $files): ?>
                <?php foreach ($files as $file): ?>
                <li class="file">
                    <a href="view.php?file=<?= urlencode($file['file']) ?>">
                        <?= htmlspecialchars($file['title']) ?>
                    </a>
                    |
                    <a href="edit.php?file=<?= urlencode($file['file']) ?>" style="color: blue;">✏️ Redigera</a>
                    |
                    <button onclick="confirmDelete('<?= htmlspecialchars($file['file']) ?>')" style="color: red; border: none; background: none; cursor: pointer;">
                        ❌ Radera
                    </button>
                    <?php endforeach; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endforeach; ?>
            <!-- list all images -->
            <div class="category" onclick="toggleCategory('images')">
                <strong>Images</strong> ▼
            </div>
            <ul id="images" class="file-list">
                <?php
        $images = glob("content/*.{png,jpg,jpeg,gif}", GLOB_BRACE);
        foreach ($images as $image) {
            $title = basename($image);
            $markdownTag = "![{$title}](content/{$title})";
            echo "<li class='file'><a href='$image'>$title</a> | <button onclick='copyToClipboard(`$markdownTag`)' style='color: green;'>📋 Copy</button> | <button onclick='confirmDelete(\"$image\")' style='color: red; border: none; background: none; cursor: pointer;'>❌ Radera</button></li>";
        }
    } ?>
     <script src="js/script.js"></script>
    </body>

</html>

