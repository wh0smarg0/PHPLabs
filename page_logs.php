<?php
/**
 * page_logs.php
 * Сторінка для відображення та аналізу логів (Пункт 2h).
 */
$start_time = microtime(true);
include "common.php"; 
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Логи подій</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-page="page_logs.php">

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
        <h2>Результати логування подій (Immediate vs LocalStorage)</h2>
        <p>Для порівняння ефективності методів, дані з бази даних відображено у двох колонках. Для оновлення натисніть F5.</p>
        
        <div id="logDisplayArea" class="log-display">
            <div id="logImmediate" class="log-column">
                <h4>Спосіб 1: Immediate Log (Сервер)</h4>
                <p>Дані завантажуються...</p>
            </div>
            <div id="logLocalStorage" class="log-column">
                <h4>Спосіб 2: LocalStorage Log (Клієнт)</h4>
                <p>Дані завантажуються...</p>
            </div>
        </div>
    </div>
    <div class="right-top data-editable" id="content_t2"><?php echo $texts[2]; ?></div>
    <div class="right-bottom data-editable" id="content_t3"><?php echo $texts[3]; ?></div>

    <div class="footer">
        <div class="y data-editable" id="content_y"><?php echo $y; ?></div>
        <div class="footer-text data-editable" id="content_t4"><?php echo $texts[4]; ?></div>
    </div>

</div>

<script src="script.js"></script> 
<script src="anim_logs.js"></script> 
<?php
// Обчислення часу
$end_time = microtime(true);
$execution_time = $end_time - $start_time;
?>

<div class="time-info">
    Час формування сторінки: <?php echo round($execution_time, 4); ?> сек.
</div>

</body>
</html>