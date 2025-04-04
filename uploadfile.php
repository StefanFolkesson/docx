<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die(json_encode(["status" => "error", "message" => "Access denied."]));
}

$uploadDir = "content/";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];
    $fileName = basename($file["name"]);
    $fileTmp = $file["tmp_name"];
    $fileSize = $file["size"];

    // 1️⃣ Ensure file has .md extension
    if (pathinfo($fileName, PATHINFO_EXTENSION) !== "md") {
        die(json_encode(["status" => "error", "message" => "Only Markdown files (.md) are allowed."]));
    }

    // 2️⃣ Check file size (Optional: max 2MB)
    if ($fileSize > 2 * 1024 * 1024) { 
        die(json_encode(["status" => "error", "message" => "File is too large. Max 2MB."]));
    }


    // 4️⃣ Move the file to the content directory
    $targetFile = $uploadDir . $fileName;
    if (move_uploaded_file($fileTmp, $targetFile)) {
        echo json_encode(["status" => "success", "message" => "Markdown file uploaded!", "file" => $targetFile]);
    } else {
        echo json_encode(["status" => "error", "message" => "Upload failed."]);
    }
}
?>
