// collapse_create.js
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById('collapse-items-container');
    const addItemBtn = document.getElementById('addItemBtn');
    const saveCollapsesBtn = document.getElementById('saveCollapsesBtn');
    const statusMessage = document.getElementById('statusMessage');

    let itemCount = 0;

    // 1. Функція додавання нового елемента форми
    function addItem() {
        const itemHtml = `
            <div class="collapse-item-container" data-id="${itemCount}">
                <h4>Елемент #${itemCount + 1}</h4>
                <input type="text" class="item-title" placeholder="Заголовок Collapse" value="Заголовок ${itemCount + 1}">
                <textarea class="item-content" placeholder="Вміст, що розкривається">Це вміст для ${itemCount + 1}-го елемента.</textarea>
                <button type="button" class="remove-item-btn" style="background: #b33939; color: white;">Видалити</button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', itemHtml);
        itemCount++;
    }

    // 2. Функція збору та збереження даних (Пункт 2c)
    function saveCollapses() {
        const collapseItems = [];
        container.querySelectorAll('.collapse-item-container').forEach((item, index) => {
            collapseItems.push({
                title: item.querySelector('.item-title').value,
                content: item.querySelector('.item-content').value,
                item_index: index // Зберігаємо порядок
            });
        });

        statusMessage.textContent = 'Збереження...';
        saveCollapsesBtn.disabled = true;

        fetch('save_collapses.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ items: collapseItems })
        })
        .then(response => response.json())
        .then(data => {
            statusMessage.textContent = data.message;
        })
        .catch(error => {
            statusMessage.textContent = 'Помилка мережі: ' + error.message;
        })
        .finally(() => {
            saveCollapsesBtn.disabled = false;
        });
    }

    // Обробники подій
    addItemBtn.addEventListener('click', addItem);
    saveCollapsesBtn.addEventListener('click', saveCollapses);
    
    // Обробник для динамічного видалення елементів
    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-item-btn')) {
            e.target.closest('.collapse-item-container').remove();
            // Тут можна скинути itemCount, але простіше просто перенумерувати при збереженні
        }
    });

    // Додаємо один елемент при завантаженні для прикладу
    addItem();
});