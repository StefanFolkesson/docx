<?php
session_start();
require "functions.php";
checkLogin();
require "parsedown.php"; 

$Parsedown = new Parsedown();
$file = isset($_GET['file']) ? basename($_GET['file']) : '';

$filePath = "content/$file";

$ok=null;
// Om formuläret har skickats, uppdatera filen
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newSubject = "ämne:".trim($_POST["yamlsubject"]);
    $newCategory = "kategori:".trim($_POST["yamlkat"]);
    $newTitle = "titel:".trim($_POST["yamltit"]);
    $newSub = "sub:".trim($_POST["yamlsub"]);
    $newYaml = $newSubject . "\n" . $newCategory . "\n" . $newTitle. "\n" . $newSub;
    $newYaml = trim($newYaml);
    $newMarkdown = trim($_POST["markdown"]);
    
    // Skriv tillbaka filen med YAML + Markdown
    $newContent = "---\n" . $newYaml . "\n---\n" . $newMarkdown;
    
    if (file_put_contents($filePath, $newContent)) {
        $ok=true;
       
    } else {
        $ok=false;
     
    }

//    header("Location: view.php?file=$file");
}
// Kontrollera om filen finns
if (!$file || !file_exists($filePath)) {
    die("Filen finns inte.");
}

$content = file_get_contents($filePath);

// Läs metadata
preg_match('/^---\s*(.*?)\s*---/s', $content, $matches);
$metadata = [];
$yaml = '';

if ($matches) {
    $yaml = $matches[1];
    $content = preg_replace('/^---\s*(.*?)\s*---/s', '', $content);
}

$lines = explode("\n", $yaml);
$metadata = [];

foreach ($lines as $line) {
    if (strpos($line, ':') !== false) {
        list($key, $value) = explode(':', $line, 2);
        $metadata[trim($key)] = trim($value);
    }
}


?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redigera <?= htmlspecialchars($file) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
    require "menu.php"; 
    $subject = $metadata['ämne'] ?? 'Övrigt';
    $category = $metadata['kategori'] ?? 'Okategoriserad';
    $title = $metadata['titel'] ?? basename($file, ".md");
    $sub = $metadata['sub'] ?? '';
    ?>
    <h1>Redigera <?= htmlspecialchars($file) ?></h1>

    <form action="edit.php?file=<?= urlencode($file) ?>" method="post">
        <button type="submit" id="save_button">Spara ändringar</button>
        <button type="button" id="view_button" onclick="goTo('<?= $file ?>');">Se dokument</button>
        <h3>YAML-metadata</h3>
        <div style="display:flex; justify-content: space-between;">
            <div>
                <div style="position: relative;">
                    <label>Ämne</label><br/>
                    <input type="text" name="yamlsubject" value="<?= htmlspecialchars($subject) ?>"  autocomplete="off">
                </div>
                <div style="position: relative;">
                    <label>Kategori</label><br/>
                    <input type="text" name="yamlkat" value="<?= htmlspecialchars($category) ?>" autocomplete="off">
                </div>
            </div>
            <div>
                <div>
                    <label>Titel</label><br/>
                    <input type="text" name="yamltit" value="<?= htmlspecialchars($title) ?>">
                </div>
                <div>
                    <label>Underkategori</label><br/>
                    <input type="text" name="yamlsub" value="<?= htmlspecialchars($sub) ?>">
                </div>
            </div>
            <div class="imagelist">
                <?php
        $images = glob("content/*.{png,jpg,jpeg,gif}", GLOB_BRACE);
        foreach ($images as $image) {
            $title = basename($image);
            $markdownTag = "![{$title}](content/{$title})";
//            $inputfield='document.querySelector("textarea[name=`markdown`]")';
            ?>
            <li class='file'><a href='<?= $image ?>'><?= $title ?></a> 
            | <span onclick="insertAtCursor('textarea[name=\'markdown\']','<?= $markdownTag ?>')">📎Insert</span>
            | <span onclick='copyToClipboard(`$markdownTag`)'>📋 Copy</span> 
            | <span onclick='confirmDelete(\"$image\")' style='color: red; border: none; background: none; cursor: pointer;'>❌ Radera</span></li>
            <?php
        }
     ?>

</div>
</div>
        <h3>Markdown-innehåll</h3>
        <textarea name="markdown"><?= htmlspecialchars($content) ?></textarea>

    </form>
    <script src="js/script.js"></script>
    <script src="js/edit.js"></script>
    <?php
    if(isset($ok))
        if ($ok) {
            echo "<script>showNotification('Filen har sparats!', 'success');</script>";
        } else {
            echo "<script>showNotification('Fel vid sparande!', 'error');</script>";
        }
    ?>
</body>
</html>

