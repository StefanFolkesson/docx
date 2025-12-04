<?php
function checklogin(){
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}
}
function readMetadata($file) {
    $content = file_get_contents($file);
    
    if (preg_match('/^---\s*(.*?)\s*---/s', $content, $matches)) {
        $yaml = $matches[1];
        $lines = explode("\n", $yaml);
        $metadata = [];

        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $metadata[trim($key)] = trim($value);
            }
        }
        return $metadata;
    }
    return [];
}
function getSubjectsAndCategories() {
    $files = glob("content/*.md");
    $menu = [];

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $metadata = [];
        if (preg_match('/^---\s*(.*?)\s*---/s', $content, $matches)) {
            $yaml = $matches[1];
            $lines = explode("\n", $yaml);

            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    list($key, $value) = explode(':', $line, 2);
                    $metadata[trim($key)] = trim($value);
                }
            }
        }
        $subject = $metadata['ämne']??'Övrigt';
        $category = $metadata['kategori'] ?? 'Okategoriserad';
        $title = $metadata['titel'] ?? basename($file, ".md");
        $sub = $metadata['sub'] ?? '';

        $menu[$subject][$category][] = [
            'file' => basename($file),
            'subject' => $subject,
            'category' => $category,
            'title' => $title,
            'sub' => $sub
        ];
        // Sort on title
        // Sort on Sub then on title
    }
    // menu consist of subjects, categories and titles and subs
    // Sort the menu by subject and category and then sub and lastly title
    ksort($menu);
    foreach ($menu as $subject => &$categories) {
        ksort($categories);
        foreach ($categories as $category => &$files) {
            usort($files, function($a, $b) {
                $subComparison = strcmp($a['sub'], $b['sub']);
                if ($subComparison === 0) {
                    return strcmp($a['title'], $b['title']);
                }
                return $subComparison;
            });
        }
    }
    return $menu;
}

