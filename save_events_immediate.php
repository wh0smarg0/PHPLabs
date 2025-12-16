<?php
/**
 * save_events_immediate.php
 * Приймає дані про ОДНУ подію одразу після її виникнення (Спосіб 1).
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

// Отримання даних
$event_id = (int)($_POST['event_id'] ?? 0);
$type = trim($_POST['type'] ?? '');
$local_time = trim($_POST['local_time'] ?? ''); // Локальний час клієнта

if (empty($event_id) || empty($type) || empty($local_time)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing data']);
    exit;
}

try {
    // Вставка даних. server_time фіксується MySQL через TIMESTAMP
    $sql = "INSERT INTO events_log (event_id, type, method, local_time) VALUES (?, ?, 'Immediate', ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $event_id, $type, $local_time);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'ok']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>