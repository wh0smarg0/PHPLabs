<?php
// save_collapses.php (Пункт 2c)
include "db.php";
header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Помилка підключення до БД.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$items = $data['items'] ?? [];

try {
    // 1. Очищення старої таблиці
    $conn->query("TRUNCATE TABLE collapses"); 

    if (empty($items)) {
        echo json_encode(['status' => 'ok', 'message' => 'Набір очищено.']);
        exit;
    }
    
    // 2. Підготовка та вставка нових даних
    $stmt = $conn->prepare("INSERT INTO collapses (item_index, title, content) VALUES (?, ?, ?)");
    
    foreach ($items as $item) {
        $index = $item['item_index'];
        // Очищення вмісту: title - від тегів, content - залишаємо теги
        $title = strip_tags($item['title']); 
        $content = $item['content']; 
        
        $stmt->bind_param("iss", $index, $title, $content);
        $stmt->execute();
    }
    $stmt->close();
    
    echo json_encode(['status' => 'ok', 'message' => 'Набір Collapse успішно оновлено.']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Помилка БД: ' . $e->getMessage()]);
}
$conn->close();
?>