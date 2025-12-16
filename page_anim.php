<?php 
/**
 * page_anim.php
 * Комп’ютерний практикум No5: Анімація та логування подій.
 */
$start_time = microtime(true);
include "common.php"; 
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Практикум 5: Анімація</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-page="page_anim.php">

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
        
        <h2>Експеримент із підвищеним навантаженням (Два круги)</h2>
    
        <div id="controls-outer" class="controls-area-outer">
            
            <div class="button-group">
                <button id="playBtn">start</button>
                <button id="stopBtn" style="display: none;">stop</button>
                <button id="reloadBtn" style="display: none;">reload</button>
            </div>
            
            <button id="closeBtn">close</button>
            
            <div id="message" class="message-box">Натисніть "start" для початку руху.</div>
            <div id="status" class="status-box">Status: Ready.</div>
        </div>
        
        <div id="work" class="work-area">
            <div id="circle1" class="anim-object">C1</div>
            <div id="circle2" class="anim-object">C2</div>
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
<script src="anim_logic.js"></script> 
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