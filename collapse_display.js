// collapse_display.js
// Ванільний JS для функціонування Collapse (Пункт 2d)
function toggleCollapse(id) {
    const content = document.getElementById(id);
    const button = document.querySelector(`[data-target="${id}"]`);

    if (content.style.maxHeight && content.style.maxHeight !== '0px') {
        content.style.maxHeight = null;
        button.classList.remove('active');
    } else {
        content.style.maxHeight = content.scrollHeight + "px";
        button.classList.add('active');
    }
}

let lastKnownUpdate = 0;
const MAIN_CONTENT_CONTAINER_ID = 'main-content-display'; 
const UPDATE_INTERVAL = 5000; // 5 секунд (Пункт 2e)
const updateStatus = document.getElementById('updateStatus');

// Функція генерації та відображення Collapse (Пункт 2d)
function updateCollapseDisplay() {
    fetch('get_collapses.php')
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'ok') {
                document.getElementById(MAIN_CONTENT_CONTAINER_ID).innerHTML = '<p>Помилка завантаження даних.</p>';
                return;
            }

            const collapses = data.items;
            lastKnownUpdate = data.latest_update; 

            let html = '';
            collapses.forEach((item, index) => {
                const targetId = 'collapse-' + index;
                
                html += `
                    <button class="collapse-toggle" data-target="${targetId}" onclick="toggleCollapse('${targetId}')">
                        ${item.title} 
                    </button>
                    <div id="${targetId}" class="collapse-content">
                        <div class="inner-content">${item.content}</div>
                    </div>
                `;
            });
            document.getElementById(MAIN_CONTENT_CONTAINER_ID).innerHTML = html;
            updateStatus.textContent = `Оновлено: ${new Date().toLocaleTimeString()} (з сервера)`;
        })
        .catch(error => console.error('Error fetching collapses:', error));
}


// Функція періодичного контролю змін (Пункт 2e)
function checkUpdates() {
    fetch(`get_collapses.php?last_check=${lastKnownUpdate}`)
        .then(response => response.json())
        .then(data => {
            if (data.has_changed) {
                // Якщо сервер підтвердив зміни
                updateCollapseDisplay(); 
            } else {
                updateStatus.textContent = `Останнє оновлення: ${new Date().toLocaleTimeString()} (без змін)`;
            }
        })
        .catch(error => console.error('Error checking updates:', error));
}

// Ініціалізація та запуск
document.addEventListener('DOMContentLoaded', () => {
    // 1. Початкове завантаження контенту
    updateCollapseDisplay(); 
    
    // 2. Запуск періодичного контролю
    setInterval(checkUpdates, UPDATE_INTERVAL); 
});