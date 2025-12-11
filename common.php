<?php
// Змінні для X та Y
$x = "Вітаємо на сайті про фрукти та здорове харчування!";
$y = "Смачно та корисно з фруктами щодня!";

$menu = [
    "index.php" => "Головна",
    "page2.php" => "Фрукти",
    "page3.php" => "Рецепти",
    "page4.php" => "Цікаві факти",
    "page5.php" => "Контакти"
];

// Всі тексти для сторінок
$pages_texts = [

    // Сторінка 1: Головна
    "index.php" => [
        "<h3>Короткі факти про користь фруктів:</h3>
        <ul>
            <li>Фрукти багаті на вітаміни та мінерали.</li>
            <li>Допомагають підтримувати імунітет.</li>
            <li>Знижують ризик серцево-судинних захворювань.</li>
            <li>Містять клітковину, що покращує травлення.</li>
            <li>Низькокалорійні та смачні!</li>
        </ul>",

        "<h2>Чому варто їсти фрукти щодня</h2>
        <p>Фрукти — це природне джерело енергії, вітамінів та антиоксидантів. Вони допомагають боротися зі стресом, зміцнюють імунітет та підтримують нормальний рівень цукру в крові. Регулярне споживання фруктів знижує ризик хронічних захворювань та покращує настрій. Навіть одне яблуко на день може позитивно впливати на ваше здоров’я.</p>",

        "<h3>Порада дня:</h3><p>З’їж яблуко замість шоколадки — твій організм скаже «дякую»!</p>",

        "<blockquote>Харчування — це наш другий мозок.</blockquote>",

        "Автор: Сахно Маргарита, 2025"
    ],

// Сторінка 2: Фрукти
"page2.php" => [
    "<h3>Список фруктів:</h3>
    <ul id='fruit-list'>
        <li data-img='apple.jpg'>Яблуко</li>
        <li data-img='pear.jpg'>Груша</li>
        <li data-img='plum.jpg'>Слива</li>
        <li data-img='banana.jpg'>Банан</li>
        <li data-img='orange.jpg'>Апельсин</li>
    </ul>",

    "<h2>Інтерактивна карта фруктів</h2>
    <img id='fruit-image' src='apple.jpg' alt='Фрукт' style='width:300px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.6);'>
    <script>
        const listItems = document.querySelectorAll('#fruit-list li');
        const fruitImage = document.getElementById('fruit-image');
        listItems.forEach(item => {
            item.addEventListener('click', () => {
                fruitImage.style.opacity = 0;
                setTimeout(() => {
                    fruitImage.src = item.getAttribute('data-img');
                    fruitImage.style.opacity = 1;
                }, 200);
            });
        });
    </script>
    <style>
        #fruit-list li { cursor: pointer; margin-bottom: 8px; transition: color 0.3s; }
        #fruit-list li:hover { color: #feca57; }
        #fruit-image { transition: opacity 0.3s ease-in-out; }
    </style>",

    "<h3>Сезонність фруктів</h3>
    <p>Яблука — осінь, апельсини — зима, банани — круглий рік і т.д.</p>",

    "<h3>Міні-таблиця з вітамінами:</h3>
    <table border='1'>
        <tr><th>Фрукт</th><th>A</th><th>B</th><th>C</th></tr>
        <tr><td>Яблуко</td><td>0.1</td><td>0.02</td><td>8</td></tr>
        <tr><td>Апельсин</td><td>0.2</td><td>0.03</td><td>50</td></tr>
    </table>",

    "Автор: Сахно Маргарита, 2025"
],

    // Сторінка 3: Рецепти
// Сторінка 3: Рецепти
"page3.php" => [
    "<h3>Прості рецепти з фруктами:</h3>
    <ul id='recipe-list'>
        <li data-img='salad.jpg' data-desc='Змішати яблуко, банан, апельсин, додати йогурт.'>Фруктовий салат</li>
        <li data-img='smuzi.jpg' data-desc='Змішати банан, ківі, апельсиновий сік і трохи меду.'>Смузі</li>
        <li data-img='toast.jpg' data-desc='Тост з маскарпоне, ягодами та нарізаними фруктами.'>Фруктові тости</li>
    </ul>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const listItems = document.querySelectorAll('#recipe-list li');
            const recipeImage = document.getElementById('recipe-image');
            const recipeDesc = document.getElementById('recipe-desc');
            listItems.forEach(item => {
                item.addEventListener('click', () => {
                    // плавне затемнення картинки і опису
                    recipeImage.style.opacity = 0;
                    recipeDesc.style.opacity = 0;
                    setTimeout(() => {
                        recipeImage.src = item.getAttribute('data-img');
                        recipeDesc.textContent = item.getAttribute('data-desc');
                        recipeImage.style.opacity = 1;
                        recipeDesc.style.opacity = 1;
                    }, 200);
                });
            });
        });
    </script>
    <style>
        #recipe-list li { cursor: pointer; margin-bottom: 8px; transition: color 0.3s; }
        #recipe-list li:hover { color: #feca57; }
        #recipe-image, #recipe-desc { transition: opacity 0.3s ease-in-out; }
        #recipe-image { border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.6); width:300px; display:block; margin-top:10px; }
        #recipe-desc { margin-top:10px; }
    </style>",

    "<h2>Рецепт</h2>
    <p id='recipe-desc'>Змішати яблуко, банан, апельсин, додати йогурт.</p>
    <img id='recipe-image' src='salad.jpg' alt='Рецепт' />",

    "<h3>Порада по здоровому харчуванню:</h3>
    <p>Їжте фрукти щодня для підтримки енергії та імунітету.</p>",

    "<h3>Міні-факт:</h3>
    <p>Ківі містить більше вітаміну C, ніж апельсин.</p>",

    "<p>Додаткові рецепти: <a href='https://www.cookery.com'>cookery.com</a></p>"
],

    // Сторінка 4: Цікаві факти
"page4.php" => [
    "<h3>Цікаві факти про фрукти:</h3>
    <ul>
        <li>Банани — ягоди.</li>
        <li>Яблука вирощують більше 4000 років.</li>
        <li>Сливи допомагають травленню.</li>
    </ul>",

    "<h3>Інфографіка фруктів</h3>
    <div class='infographic'>
        <div class='infobox'>
            <img src='banana.png' alt='Банан'>
            <p>Банани — чудове джерело калію</p>
        </div>
        <div class='infobox'>
            <img src='apple.png' alt='Яблуко'>
            <p>Яблука зміцнюють імунітет</p>
        </div>
        <div class='infobox'>
            <img src='plum.png' alt='Слива'>
            <p>Сливи покращують травлення</p>
        </div>
    </div>
    <style>
        .infographic { display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-top: 15px; }
        .infobox { background: #3d3d3d; padding: 15px; border-radius: 12px; text-align: center; width: 150px; box-shadow: 0 4px 12px rgba(0,0,0,0.6); transition: transform 0.3s; }
        .infobox:hover { transform: translateY(-5px); }
        .infobox img { width: 80px; height: 80px; object-fit: contain; margin-bottom: 8px; }
        .infobox p { margin: 0; font-size: 14px; color: #f1f1f1; }
    </style>",

    "<h3>Історичний факт:</h3><p>Яблука вирощували ще в Стародавньому Єгипті.</p>",

    "<blockquote class='fancy-quote'>Їжте фрукти щодня — це корисно!</blockquote>
<blockquote class='fancy-quote'>Одне яблуко на день тримає лікаря подалі.</blockquote>
    <blockquote class='fancy-quote'>Фрукти — це солодке щастя від природи.</blockquote>
<style>
.fancy-quote {
    position: relative;
    background: #3d3d3d;
    border-left: 5px solid #feca57;
    padding: 15px 20px;
    margin: 20px 0;
    font-style: italic;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.6);
    border-radius: 8px;
}
.fancy-quote::before {
    content: \"\";
    font-size: 40px;
    position: absolute;
    top: 5px;
    left: 10px;
    color: #feca57;
    font-family: serif;
}
</style>",

    "Автор: Сахно Маргарита, 2025"
],


    // Сторінка 5: Контакти / Про автора
    "page5.php" => [
        "<h3>Про автора:</h3>
        <p>Ім’я: Сахно Маргарита<br>Група: ІО-35<br>E-mail: sakhno.margaryta@lll.kpi.ua</p>",

        "<h3>Форма зворотного зв’язку:</h3>
        <form action='page5.php' method='post'>
            <input type='text' name='name' placeholder='Ваше ім’я'><br>
            <textarea name='message' placeholder='Повідомлення'></textarea><br>
            <button type='submit'>Відправити</button>
        </form>",

        "<h3>Соцмережі та посилання:</h3>
        <p><a href='#'>Instagram</a> | <a href='#'>Facebook</a> | <a href='#'>Telegram</a></p>",

        "<p>Їж фрукти — будь здоровий</p>",

        "<p>&copy; 2025 Марго</p>"
    ]
];

// Визначаємо поточну сторінку
$current_page = basename($_SERVER['PHP_SELF']);

// Підставляємо тексти для поточної сторінки
$texts = $pages_texts[$current_page] ?? ["", "", "", "", ""];
?>
