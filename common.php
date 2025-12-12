<?php
/**
 * common.php
 * Налаштування змінних, меню, початкових даних та логіка підтягування контенту з БД.
 */

// 1. ПІДКЛЮЧЕННЯ ДО БД
// Включаємо файл з параметрами підключення ($host, $user, $password, $dbname, $port)
// У цьому місці об'єкт з'єднання $conn має стати доступним.
include "db.php"; 

// --- 2. ПОЧАТКОВІ (СТАТИЧНІ) ДАНІ ---

$x_default = "Вітаємо на сайті про фрукти та здорове харчування!";
$y_default = "Смачно та корисно з фруктами щодня!";

$menu = [
    "index.php" => "Головна",
    "page2.php" => "Фрукти",
    "page3.php" => "Рецепти",
    "page4.php" => "Цікаві факти",
    "page5.php" => "Контакти"
];

// Усі початкові тексти для сторінок, індексовані за їх ID (pages_texts перейменовано на default_texts для ясності)
$default_texts = [
    // Загальні елементи
    "content_x" => $x_default,
    "content_y" => $y_default,
    
    // index.php
    "index.php" => [
        "content_t0" => "<h3>Короткі факти про користь фруктів:</h3><ul><li>Фрукти багаті на вітаміни та мінерали.</li><li>...</li></ul>",
        "content_t1" => "<h2>Чому варто їсти фрукти щодня</h2><p>Фрукти — це природне джерело енергії, вітамінів та антиоксидантів...</p>",
        "content_t2" => "<h3>Порада дня:</h3><p>З’їж яблуко замість шоколадки — твій організм скаже «дякую»!</p>",
        "content_t3" => "<blockquote>Харчування — це наш другий мозок.</blockquote>",
        "content_t4" => "Автор: Сахно Маргарита, 2025"
    ],
    
    // page2.php
    "page2.php" => [
        "content_t0" => "<h3>Список фруктів:</h3><ul id='fruit-list'><li>Яблуко</li><li>Груша</li><li>...</li></ul>",
        "content_t1" => "<h2>Інтерактивна карта фруктів</h2><img id='fruit-image' src='apple.jpg' alt='Фрукт' style='width:300px;...'>...",
        "content_t2" => "<h3>Сезонність фруктів</h3><p>Яблука — осінь, апельсини — зима, банани — круглий рік і т.д.</p>",
        "content_t3" => "<h3>Міні-таблиця з вітамінами:</h3><table border='1'><tr><th>Фрукт</th><th>A</th><th>B</th><th>C</th></tr><tr><td>...</td></tr></table>",
        "content_t4" => "Автор: Сахно Маргарита, 2025"
    ],
    
    // page3.php
    "page3.php" => [
        "content_t0" => "<h3>Прості рецепти з фруктами:</h3><ul id='recipe-list'><li>Фруктовий салат</li><li>Смузі</li><li>...</li></ul> <script>...</script>",
        "content_t1" => "<h2>Рецепт</h2><p id='recipe-desc'>Змішати яблуко, банан, апельсин, додати йогурт.</p><img id='recipe-image' src='salad.jpg' alt='Рецепт' />",
        "content_t2" => "<h3>Порада по здоровому харчуванню:</h3><p>Їжте фрукти щодня для підтримки енергії та імунітету.</p>",
        "content_t3" => "<h3>Міні-факт:</h3><p>Ківі містить більше вітаміну C, ніж апельсин.</p>",
        "content_t4" => "<p>Додаткові рецепти: <a href='https://www.cookery.com'>cookery.com</a></p>"
    ],
    
    // page4.php
    "page4.php" => [
        "content_t0" => "<h3>Цікаві факти про фрукти:</h3><ul><li>Банани — ягоди.</li><li>Яблука вирощують більше 4000 років.</li><li>...</li></ul>",
        "content_t1" => "<h3>Інфографіка фруктів</h3><div class='infographic'>...</div> <style>...</style>",
        "content_t2" => "<h3>Історичний факт:</h3><p>Яблука вирощували ще в Стародавньому Єгипті.</p>",
        "content_t3" => "<blockquote class='fancy-quote'>Їжте фрукти щодня — це корисно!</blockquote><blockquote class='fancy-quote'>Одне яблуко на день тримає лікаря подалі.</blockquote> <style>...</style>",
        "content_t4" => "Автор: Сахно Маргарита, 2025"
    ],

    // page5.php
    "page5.php" => [
        "content_t0" => "<h3>Про автора:</h3><p>Ім’я: Сахно Маргарита<br>Група: ІО-35<br>E-mail: sakhno.margaryta@lll.kpi.ua</p>",
        "content_t1" => "<h3>Форма зворотного зв’язку:</h3><form action='page5.php' method='post'>...</form>", 
        "content_t2" => "<h3>Соцмережі та посилання:</h3><p><a href='#'>Instagram</a> | <a href='#'>Facebook</a> | <a href='#'>Telegram</a></p>",
        "content_t3" => "<p>Їж фрукти — будь здоровий</p>",
        "content_t4" => "<p>&copy; 2025 Марго</p>"
    ]
];


// --- 3. ЛОГІКА ПІДТЯГУВАННЯ ДАНИХ З БД (Пункт 3) ---

$current_page = basename($_SERVER['PHP_SELF']);
$x = $default_texts['content_x']; 
$y = $default_texts['content_y']; 
$texts_assoc = $default_texts[$current_page] ?? []; // Асоціативний масив для поточної сторінки

// Створюємо список усіх ID, які потрібно перевірити в таблиці page_content
$elements_to_check = ['content_x', 'content_y'];
if (isset($default_texts[$current_page])) {
    $elements_to_check = array_merge($elements_to_check, array_keys($default_texts[$current_page]));
}

// Якщо з'єднання з БД встановлено, виконуємо підстановку
if ($conn && !$conn->connect_error) {
    
    $placeholders = implode(',', array_fill(0, count($elements_to_check), '?'));
    $sql = "SELECT element_id, content FROM page_content WHERE page_name = ? AND element_id IN ($placeholders)";
    
    $stmt = $conn->prepare($sql);
    
    $param_types = 's' . str_repeat('s', count($elements_to_check));
    $params = array_merge([$current_page], $elements_to_check);

    // Функція array_by_ref допомагає передати параметри mysqli::bind_param за посиланням
    $bind_params = array_merge([$param_types], $params);
    call_user_func_array([$stmt, 'bind_param'], array_by_ref($bind_params));
    
    $stmt->execute();
    $result = $stmt->get_result();

    // Замінюємо початкові дані на дані з БД
    while ($row = $result->fetch_assoc()) {
        $element_id = $row['element_id'];
        $content = $row['content'];

        if ($element_id === 'content_x') {
            $x = $content;
        } elseif ($element_id === 'content_y') {
            $y = $content;
        } elseif (array_key_exists($element_id, $texts_assoc)) {
            $texts_assoc[$element_id] = $content;
        }
    }
    $stmt->close();
}

// Функція-допоміжний елемент для коректної передачі посилань в bind_param
function array_by_ref(array &$arr) {
    $refs = array();
    foreach($arr as $key => $value)
        $refs[$key] = &$arr[$key];
    return $refs;
}


// 4. Створення масиву $texts для сторінок (як $texts[0], $texts[1]...)
// Перетворюємо асоціативний масив у числовий для використання в HTML-шаблонах
$final_texts = [];
$i = 0;
foreach($default_texts[$current_page] ?? [] as $key => $value) {
    // Використовуємо або змінений (з $texts_assoc), або дефолтний контент
    $final_texts[$i] = $texts_assoc[$key] ?? $value;
    $i++;
}
$texts = $final_texts; 
?>
