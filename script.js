document.addEventListener("DOMContentLoaded", () => {
    // Отримуємо назву поточної сторінки з атрибута data-page тега <body>
    const pageName = document.body.dataset.page; 

    // Вибираємо всі елементи, які позначені як редаговані (Пункт 2)
    // Використовуємо клас data-editable, який ми додали в HTML
    const editableBlocks = document.querySelectorAll('.data-editable');

    editableBlocks.forEach(block => {

        // Додаємо обробник події кліку для активації режиму редагування
        block.addEventListener('click', function activateEditMode(e) {
            e.stopPropagation();

            // Запобігаємо повторному відкриттю форми
            if (block.querySelector('.edit-form')) return;

            // Видаляємо обробник, щоб не можна було клікнути по формі
            block.removeEventListener('click', activateEditMode);

            const elementId = block.id; // Унікальний ID елемента (наприклад, content_x)
            const oldContent = block.innerHTML;

            // Створюємо форму редагування з використанням CSS-класів
            const form = document.createElement('div');
            form.className = 'edit-form'; 

            // Структура форми
            form.innerHTML = `
                <textarea>${oldContent}</textarea>
                <div class="edit-actions">
                    <button class="save-btn">Зберегти</button>
                    <button class="cancel-btn">Скасувати</button>
                </div>
            `;
            
            block.innerHTML = "";
            block.appendChild(form);

            const textarea = form.querySelector('textarea');
            const saveBtn = form.querySelector('.save-btn');
            const cancelBtn = form.querySelector('.cancel-btn');

            // Функція відновлення початкового стану
            const restoreState = (content) => {
                block.innerHTML = content;
                block.addEventListener('click', activateEditMode);
            };

            // Обробник "Скасувати"
            cancelBtn.addEventListener('click', (e) => {
                e.preventDefault();
                restoreState(oldContent);
            });

            // Обробник "Зберегти" (AJAX-запит до PHP/MySQL - Пункт 2 і 3)
            saveBtn.addEventListener('click', (e) => {
                e.preventDefault();
                const newContent = textarea.value;
                
                saveBtn.disabled = true;
                cancelBtn.disabled = true;
                
                // Виконуємо AJAX-запит для збереження в БД
                fetch('save_block.php', { 
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    // Надсилаємо назву сторінки, ID елемента та новий вміст
                    body: `page=${encodeURIComponent(pageName)}&element_id=${encodeURIComponent(elementId)}&content=${encodeURIComponent(newContent)}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'ok') {
                        restoreState(newContent); // Оновлюємо вміст на сторінці
                    } else {
                        alert(data.message || 'Помилка збереження. Дані не були записані в БД.');
                        restoreState(oldContent); // Повертаємо старий вміст
                    }
                })
                .catch(error => {
                    alert('Помилка мережі: ' + error.message);
                    restoreState(oldContent);
                });
            });

            textarea.focus();
        });
    });
    
    // Клієнтський таймер (performance.now()) ВИДАЛЕНО, оскільки вимірювання часу
    // формування сторінки (PHP + БД) реалізовано на стороні сервера (Пункт 4).
});
