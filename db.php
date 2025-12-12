<?php

$host = "localhost";
$port = 3307; 
$user = "root";
$password = "";
$dbname = "my_website"; 

// Встановлення з'єднання
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Перевірка на помилки підключення
if ($conn->connect_error) {
    // Зупиняємо виконання, якщо неможливо підключитися до БД
    die("Помилка підключення до БД: " . $conn->connect_error);
}

// Встановлення кодування символів для коректної роботи з українською мовою
$conn->set_charset("utf8mb4"); 
?>
