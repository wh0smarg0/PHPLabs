<?php include "common.php"; ?>

<?php
// Обробка форми
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $message) {
        $entry = "Ім’я: $name\nПовідомлення: $message\n---\n";
        file_put_contents('messages.txt', $entry, FILE_APPEND);
        $feedback = "Дякуємо! Ваше повідомлення збережено.";
    } else {
        $feedback = "Будь ласка, заповніть усі поля.";
    }
} else {
    $feedback = "Немає даних для обробки.";
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Контакти / Про автора</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

    <!-- Блок 1 (шапка + X + меню) -->
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

    <!-- Блок 2: Про автора -->
    <div class="left"><?php echo $texts[0]; ?></div>

    <!-- Блок 3: Форма -->
    <div class="main">
        <?php echo $feedback; ?>
        <?php echo $texts[1]; ?>
    </div>

    <!-- Блок 4: Соцмережі -->
    <div class="right-top"><?php echo $texts[2]; ?></div>

    <!-- Блок 5: Слоган -->
    <div class="right-bottom"><?php echo $texts[3]; ?></div>

    <!-- Блок 6: Футер + Y -->
    <div class="footer">
        <div class="y"><?php echo $y; ?></div>
        <div><?php echo $texts[4] ?? ""; ?></div>
    </div>

</div>
</body>
</html>
