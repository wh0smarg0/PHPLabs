<?php
// get_collapses.php (Пункт 2d, 2e)
include "db.php";
header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Помилка підключення до БД.']);
    exit;
}

$sql = "SELECT item_index, title, content, updated_at FROM collapses ORDER BY item_index ASC";
$result = $conn->query($sql);

$items = [];
$latest_update = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
        // Знаходимо найсвіжіший час оновлення
        $timestamp = strtotime($row['updated_at']);
        if ($timestamp > $latest_update) {
             $latest_update = $timestamp;
        }
    }
}
$conn->close();

// Логіка для періодичного контролю змін (Пункт 2e)
if (isset($_GET['last_check']) && !empty($_GET['last_check'])) {
    $last_check_time = (int)$_GET['last_check'];
    $has_changed = ($latest_update > $last_check_time);
    echo json_encode(['has_changed' => $has_changed, 'latest_update' => $latest_update]);
    exit;
}

// Основний запит на отримання всіх даних
echo json_encode(['status' => 'ok', 'items' => $items, 'latest_update' => $latest_update]);
?>