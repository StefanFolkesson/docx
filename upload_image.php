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

    // 1️⃣ Ensure valid image extension
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($fileExt, $allowedExtensions)) {
        die(json_encode(["status" => "error", "message" => "Only images (.jpg, .jpeg, .png, .gif, .webp) are allowed."]));
    }

    // 2️⃣ Check file size (max 5MB)
    if ($fileSize > 5 * 1024 * 1024) { 
        die(json_encode(["status" => "error", "message" => "Image file is too large. Max 5MB."]));
    }

    // 3️⃣ Generate unique filename
//    $uniqueFileName = uniqid("img_", true) . "." . $fileExt;
    $targetFile = $uploadDir . $fileName;

    // 4️⃣ Move file to uploads folder
    if (move_uploaded_file($fileTmp, $targetFile)) {
        echo json_encode(["status" => "success", "message" => "Image uploaded!", "file" => $targetFile]);
    } else {
        echo json_encode(["status" => "error", "message" => "Upload failed."]);
    }
}
?>
