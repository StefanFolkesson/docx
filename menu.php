<?php
// Läs in ämnen och kategorier från filerna
require_once "functions.php";
$menu_menu = getSubjectsAndCategories();
?>
<div class="menu">
    <ul>
        <li><a href="index.php">📂 Hem</a></li>
        <?php foreach ($menu_menu as $menu_subject => $menu_categories): ?>
            <li>
                <?= htmlspecialchars($menu_subject) ?> ▼
                <ul class="dropdown">
                    <?php foreach ($menu_categories as $menu_category => $menu_files): ?>
                        <li>
                            <?= htmlspecialchars($menu_category) ?> ►
                            <ul class="sub-dropdown">
                                <?php foreach ($menu_files as $menu_file):  ?>
                                <li><a class='menuitem' href="view.php?file=<?= urlencode($menu_file['file']) ?>"><?= htmlspecialchars(basename($menu_file['title'], ".md")) ?></a></li>
                    <?php endforeach; ?>
                            </ul>
                        </li>
        <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
            ?>
            <li><a href="upload.php">⬆️ Ladda upp</a></li>
        <li>🔧 Admin ▼
          <ul class="dropdown">
            <li><a href="logout.php"?>Logga ut</a></li>
          </ul>
        </li>
        <?php } else { ?> 
            <li>🔧 Admin ▼
          <ul class="dropdown">
            <li><a href="login.php"?>Logga in</a></li>
          </ul>
        </li>

            <?php } ?>
    </ul>
</div>
<div id="notify" class="notify"></div>
