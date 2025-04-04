<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    die("Åtkomst nekad.");
}

function getSuggestions() {
    $files = glob("content/*.md");
    $subjects = [];
    $categories = [];

    foreach ($files as $file) {
        $content = file_get_contents($file);
        if (preg_match('/^---\s*(.*?)\s*---/s', $content, $matches)) {
            $yaml = $matches[1];
            $lines = explode("\n", $yaml);
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    list($key, $value) = explode(':', $line, 2);
                    $key = trim($key);
                    $value = trim($value);

                    if ($key === "ämne" && !in_array($value, $subjects)) {
                        $subjects[] = $value;
                    }
                    if ($key === "kategori" && !in_array($value, $categories)) {
                        $categories[] = $value;
                    }
                }
            }
        }
    }

    return ["subjects" => $subjects, "categories" => $categories];
}

header("Content-Type: application/json");
echo json_encode(getSuggestions());
