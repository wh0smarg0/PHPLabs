<?php
/**
 * Обробляє AJAX-запит на збереження контенту в базу даних MySQL (Пункт 3).
 */

// Включаємо налаштування БД
// ВИПРАВЛЕНО: Використовуємо узгоджений файл підключення
include "db.php"; 

header('Content-Type: application/json');

// 1. Перевірка підключення
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Помилка підключення до БД.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Невірний метод запиту.']);
    exit;
}

// Отримання та очищення даних, надісланих від script.js
$page_name = trim($_POST['page'] ?? '');
$element_id = trim($_POST['element_id'] ?? ''); 
$content = $_POST['content'] ?? '';

if (empty($page_name) || empty($element_id) || !isset($_POST['content'])) {
    echo json_encode(['status' => 'error', 'message' => 'Відсутні обов\'язкові дані.']);
    exit;
}

try {
    // 2. Використовуємо UPSERT (INSERT ... ON DUPLICATE KEY UPDATE)
    // Таблиця: page_content, Стовпці: page_name, element_id
    $sql = "INSERT INTO page_content (page_name, element_id, content) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE content = ?";

    $stmt = $conn->prepare($sql);
    
    // Прив'язка параметрів: ssss (page_name, element_id, content_INSERT, content_UPDATE)
    $stmt->bind_param("ssss", $page_name, $element_id, $content, $content);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'ok', 'message' => 'Вміст успішно збережено.']);
    } else {
         echo json_encode(['status' => 'error', 'message' => 'Помилка виконання SQL: ' . $stmt->error]);
    }
    
    $stmt->close();

} catch (Exception $e) {
    // Обробка не-SQL помилок
    echo json_encode(['status' => 'error', 'message' => 'Помилка бази даних: ' . $e->getMessage()]);
}

// 3. Закриття з'єднання
$conn->close();
?>
