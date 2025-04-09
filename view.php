<?php
require "parsedown.php"; 
session_start();

$Parsedown = new Parsedown();
$file = isset($_GET['file']) ? basename($_GET['file']) : '';

if (!$file || !file_exists("content/$file")) {
    die("Filen finns inte.");
}

$content = file_get_contents("content/$file");

// Läs metadata
preg_match('/^---\s*(.*?)\s*---/s', $content, $matches);
$metadata = [];
if ($matches) {
    $yaml = $matches[1];
    $lines = explode("\n", $yaml);
    foreach ($lines as $line) {
        if (strpos($line, ':') !== false) {
            list($key, $value) = explode(':', $line, 2);
            $metadata[trim($key)] = trim($value);
        }
    }
}

// Ta bort metadata från Markdown-innehållet
$content = preg_replace('/^---\s*(.*?)\s*---/s', '', $content);

$html = $Parsedown->text($content);

?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($metadata['titel'] ?? $file) ?></title>
        <!-- Länk till CSS-fil -->
        <link rel="stylesheet" href="css/style.css">
    </head>
<body>

    <?php require "menu.php"; ?>
    <div id='kategori_container'>
        <div id='kategori_meny'>
            <h3><?= $metadata['kategori']??"Okategoriserad" ?></h3>
            <ul><?php
            $sub = "";
            $amne = $metadata['ämne']??"Övrigt";
            $kat= $metadata['kategori']??"Okategoriserad";
            $kategori = $menu_menu[$amne][$kat]??"Okategoriserad";  
            foreach ($kategori as $kat_file) {
                if($sub != $kat_file['sub'] && $kat_file['sub'] != "" && $kat_file['sub'] != ""){
                    echo "<h3 class='sub'>" . htmlspecialchars($kat_file['sub']) . "</h3>";
                    $sub = $kat_file['sub'];
                }
                if($kat_file['file'] == $file){
                    echo "<li><a href='view.php?file=" . urlencode($kat_file['file']) . "' class='active'>" . htmlspecialchars($kat_file['title']) . "</a></li>";
                }else{
                echo "<li><a href='view.php?file=" . urlencode($kat_file['file']) . "'>" . htmlspecialchars($kat_file['title']) . "</a></li>";
                }
            }   
        ?></ul></div>
        <div class='view'>
            <h1><?= htmlspecialchars($metadata['titel'] ?? $file) ?></h1>
        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) : ?>
            <a id="editview" href="edit.php?file=<?= urlencode($file) ?>">✏️Redigera</a>
        <?php endif; ?>
            <div><?= $html ?></div>
        </div>
    </div>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="js/script.js"></script>
</body>
</html>
