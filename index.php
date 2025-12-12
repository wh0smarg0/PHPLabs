<?php include "common.php"; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Головна</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-page="index.php">
<div class="container">

    <!-- Блок 1 (шапка + X) -->
    <div class="header">
        <div class="x"><?php echo $x; ?></div>
        <div class="menu">
            <ul>
                <?php foreach($menu as $link => $title): ?>
                    <li><a href="<?php echo $link; ?>"><?php echo $title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Блок 2 -->
    <div class="left"><?php echo $texts[0]; ?></div>

    <!-- Блок 3 -->
    <div class="main"><?php echo $texts[1]; ?></div>

    <!-- Блок 4 -->
    <div class="right-top"><?php echo $texts[2]; ?></div>

    <!-- Блок 5 -->
    <div class="right-bottom"><?php echo $texts[3]; ?></div>

    <!-- Блок 6 (футер + Y) -->
    <div class="footer">
        <div class="y"><?php echo $y; ?></div>
        <div><?php echo $texts[4] ?? ""; ?></div>
    </div>

</div>

<script src="script.js"></script>

</body>
</html>
