<?php
/**
 * save_events_accumulated.php
 * Приймає накопичений масив подій з LocalStorage (Спосіб 2).
 * Фіксує час на сервері.
 */
include "db.php"; 
header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'DB Connection Error']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid method']);
    exit;
}

// Отримуємо JSON-дані з тіла запиту
$data = json_decode(file_get_contents('php://input'), true);
$events = $data['events'] ?? [];

if (empty($events)) {
    echo json_encode(['status' => 'ok', 'message' => 'No events received.']);
    exit;
}

try {
    // Підготовка запиту
    $sql = "INSERT INTO events_log (event_id, type, method, local_time) VALUES (?, ?, 'LocalStorage', ?)";
    $stmt = $conn->prepare($sql);
    
    // Вставка всіх подій у циклі
    foreach ($events as $event) {
        $event_id = $event['event_id'] ?? 0;
        $type = $event['type'] ?? 'Unknown';
        $local_time = $event['local_time'] ?? date('Y-m-d H:i:s'); // Використовуємо час, зафіксований в LocalStorage
        
        $stmt->bind_param("iss", $event_id, $type, $local_time);
        $stmt->execute();
    }
    
    $stmt->close();
    echo json_encode(['status' => 'ok', 'message' => count($events) . ' events saved.']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>