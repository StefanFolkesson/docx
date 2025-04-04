<?php
session_start();

// Kolla om användaren är inloggad (om du vill skydda borttagning)
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die("Åtkomst nekad.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["file"])) {
    $file = basename($_POST["file"]);
    $filePath = "content/" . $file;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "success"; // Returnera status till JavaScript
        } else {
            echo "Fel vid borttagning.";
        }
    } else {
        echo "Filen finns inte.";
    }
} else {
    echo "Ogiltig begäran.";
}
