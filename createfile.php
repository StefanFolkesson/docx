<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die(json_encode(["status" => "error", "message" => "Access denied."]));
}
$file = $_POST['fileName'].".md";
$content = $_POST['fileContent'];


$uploadDir = "content/";

// Kontrollera om filnamnet är tomt
if (empty($file)) {
    die(json_encode(["status" => "error", "message" => "File name cannot be empty."]));
}
// Skapar filen och skriver innehållet till mappen "content"
// kolla först om filen existerar
if (file_exists($uploadDir . $file)) {
    die(json_encode(["status" => "error", "message" => "File already exists."]));
}
if (file_put_contents($uploadDir . $file, $content) !== false) {
    echo json_encode(["status" => "success", "message" => "File created successfully!", "file" => $uploadDir . $file]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to create file."]);
}

?>