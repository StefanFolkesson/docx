<?php
// Läs in ämnen och kategorier från filerna
require_once "functions.php";
$menu_menu = getSubjectsAndCategories();
$sub="";
?>
<div class="menu-container">
  <ul id="logo">
    <li ><a href="index.php"><img src="images/docx(final).png"></a></li>
</ul>
    <div class="menu">
    <ul>
        <?php foreach ($menu_menu as $menu_subject => $menu_categories): ?>
            <li>
                <?= htmlspecialchars($menu_subject) ?> ▼
                <ul class="dropdown">
                    <?php foreach ($menu_categories as $menu_category => $menu_files): ?>
                        <li>
                            <?= htmlspecialchars($menu_category) ?> ►
                            <ul class="sub-dropdown">
                                <?php foreach ($menu_files as $menu_file):  ?>
                                    <?php if($menu_file['sub']!=null && $menu_file['sub'] != $sub) { 
                                        echo "<h3 class='sub'>" . htmlspecialchars($menu_file['sub']) . "</h3>";
                                        $sub = $menu_file['sub'];
                                    } ?>

                                    <li>
                                        <a class='menuitem' href="view.php?file=<?= urlencode($menu_file['file']) ?>">
                                            <?= htmlspecialchars($menu_file['title']) ?>
                                        </a>
                                    </li>
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
            <li class="ul"><a href="upload.php" title="Upload">⬆️</a></li>
            <li class="admin"><a href="logout.php" title="Logout">❌</a></li>
        <?php } else { ?> 
            <li><a href="login.php" title="Login">🔧</a></li>
            <?php } ?>
    </ul>
</div>
</div>
<div id="notify" class="notify"></div>
