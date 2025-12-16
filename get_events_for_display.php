<?php
/**
 * get_events_for_display.php
 */
set_time_limit(300);
include "db.php"; 
header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'DB Connection Error']);
    exit;
}

try {
    // ВАЖЛИВО: Додаємо LIMIT, щоб не "вбити" браузер та сервер.
    // Показуємо 2000 найсвіжіших записів.
    $sql = "SELECT event_id, type, method, local_time, server_time 
            FROM events_log 
            ORDER BY id DESC 
            LIMIT 2000";
            
    $result = $conn->query($sql);

    $events = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }
    
    // Отримуємо загальну кількість записів (для інформації)
    $countSql = "SELECT COUNT(*) as total FROM events_log";
    $countResult = $conn->query($countSql);
    $totalCount = $countResult->fetch_assoc()['total'];

    echo json_encode([
        'status' => 'ok', 
        'events' => $events,
        'count' => $totalCount, // Покажемо, скільки всього в базі
        'displayed' => count($events) // Скільки фактично передали
    ]);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'SQL Error: ' . $e->getMessage()]);
}
$conn->close();
?>