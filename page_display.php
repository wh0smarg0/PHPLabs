<?php 
/**
 * page_display.php
 * Сторінка 2: Призначена для відображення та періодичного оновлення набору об'єктів Collapse.
 * (Пункт 2d, 2e)
 */
$start_time = microtime(true); // Початок вимірювання часу
include "common.php"; // Підключаємо загальні налаштування та логіку
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Відображення Collapse (Практикум 4)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-page="page_display.php">

<div class="container">

    <div class="header">
        <div class="x data-editable" id="content_x"><?php echo $x; ?></div>
        <div class="menu">
            <ul>
                <?php foreach($menu as $link => $title): ?>
                    <li><a href="<?php echo $link; ?>"><?php echo $title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="left data-editable" id="content_t0"><?php echo $texts[0]; ?></div>

    <div class="main"> 
        <h2>Актуальний набір об'єктів Collapse з сервера</h2>
        <p>Набір динамічно завантажується з бази даних і оновлюється кожні 5 секунд.</p>
        
        <div id="main-content-display">
            <p>Очікування даних від сервера...</p>
        </div>
        
        <div id="updateStatus" style="margin-top: 15px; font-size: 14px; font-weight: bold;"></div>
    </div>

    <div class="right-top data-editable" id="content_t2"><?php echo $texts[2]; ?></div>

    <div class="right-bottom data-editable" id="content_t3"><?php echo $texts[3]; ?></div>

    <div class="footer">
        <div class="y data-editable" id="content_y"><?php echo $y; ?></div>
        <div class="footer-text data-editable" id="content_t4"><?php echo $texts[4]; ?></div>
        
        <?php $end_time = microtime(true); ?>
        <div class="time-load">Час генерації сторінки: <?php echo round($end_time - $start_time, 4); ?> сек.</div>
    </div>
</div>

<script src="script.js"></script>
<script src="collapse_display.js"></script>

</body>
</html>