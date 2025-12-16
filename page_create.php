<?php 
/**
 * page_create.php
 * Сторінка 1: Призначена для конфігурації та збереження набору об'єктів Collapse.
 * (Пункт 2a, 2b)
 */
$start_time = microtime(true); // Початок вимірювання часу
include "common.php"; // Підключаємо загальні налаштування та логіку з БД
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Створення Collapse (Практикум 4)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-page="page_create.php">

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
        <h2>Налаштування та створення набору об'єктів Collapse</h2>
        <p>Створіть довільну кількість елементів, які будуть відображені на другій сторінці.</p>
        
        <div class="collapse-form-section">
            <div id="collapse-items-container">
                <p>Натисніть "Додати елемент" для початку конфігурації.</p>
            </div>
            
            <button id="addItemBtn" class="add-item-btn">Додати елемент Collapse</button>
            <button id="saveCollapsesBtn" class="save-collapses-btn">Зберегти на сервер (AJAX)</button>
            
            <div id="statusMessage" style="margin-top: 10px; font-weight: bold;"></div>
        </div>
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
<script src="collapse_create.js"></script>

</body>
</html>