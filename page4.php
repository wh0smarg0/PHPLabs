<?php $start_time = microtime(true); // ДОДАНО: Початок вимірювання часу (Пункт 4) ?>
<?php include "common.php"; ?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Сторінка 4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-page="page4.php">

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

    <div class="main data-editable" id="content_t1"><?php echo $texts[1]; ?></div>

    <div class="right-top data-editable" id="content_t2"><?php echo $texts[2]; ?></div>

    <div class="right-bottom data-editable" id="content_t3"><?php echo $texts[3]; ?></div>

    <div class="footer">
        <div class="y data-editable" id="content_y"><?php echo $y; ?></div>
        <div class="footer-text data-editable" id="content_t4"><?php echo $texts[4]; ?></div>
    </div>

</div>

<script src="script.js"></script>

<?php
// Обчислення часу (Пункт 4)
$end_time = microtime(true);
$execution_time = $end_time - $start_time;
?>

<div class="time-info">
    Час формування сторінки: <?php echo round($execution_time, 4); ?> сек.
</div>

</body>
</html>
