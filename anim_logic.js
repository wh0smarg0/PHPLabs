document.addEventListener("DOMContentLoaded", () => {
    const work = document.getElementById('work');
    const circle1 = document.getElementById('circle1');
    const circle2 = document.getElementById('circle2');
    const messageBox = document.getElementById('message');
    const statusBox = document.getElementById('status');
    const playBtn = document.getElementById('playBtn');
    const stopBtn = document.getElementById('stopBtn');
    const reloadBtn = document.getElementById('reloadBtn');
    const closeBtn = document.getElementById('closeBtn');
    // Змінні logImmediateContainer та logLocalStorageContainer видалено.

    let animInterval = null;
    let eventCounter = 0;
    // На старті намагаємося відновити чергу з LocalStorage
    let eventsQueue = JSON.parse(localStorage.getItem('animationEvents')) || [];
    let isMoving = false;
    const circleSize = 20; // Діаметр 20px (Радіус 10px)

    let state = {
        c1: { x: 0, y: 0, dx: 3, dy: 2, wallCollision: false }, 
        c2: { x: 0, y: 0, dx: -2, dy: 4, wallCollision: false } 
    };

    // --- 1. ФУНКЦІЯ ЛОГУВАННЯ ТА ЗБЕРЕЖЕННЯ ---

    function getCurrentLocalTime() {
        const now = new Date();
        const local = new Date(now.getTime() - (now.getTimezoneOffset() * 60000));
        
        return local.toISOString().slice(0, 19).replace('T', ' ');
    }

    function logAndSaveEvent(type, logMessage, detail = {}) {
        eventCounter++;
        const localTime = getCurrentLocalTime();
        
        const eventData = {
            event_id: eventCounter,
            type: type,
            local_time: localTime,
            log_message: logMessage,
            detail: detail
        };

        // Спосіб 1: Негайне відправлення
        sendEventImmediate(eventData);

        // Спосіб 2: Акумуляція в LocalStorage
        eventsQueue.push(eventData);
        localStorage.setItem('animationEvents', JSON.stringify(eventsQueue));

        messageBox.textContent = `${logMessage} (Event ${eventCounter})`;
        statusBox.textContent = `Подія ${eventCounter}: ${type} [Local: ${localTime}]`;
    }

    function sendEventImmediate(eventData) {
        const payload = new URLSearchParams({
            event_id: eventData.event_id,
            type: eventData.type,
            local_time: eventData.local_time
        });
        
        fetch('save_events_immediate.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: payload
        }).catch(e => { /* Ігноруємо мережеві помилки для анімації */ });
    }

    // --- 2. ЛОГІКА АНІМАЦІЇ ТА КЕРУВАННЯ ---

    function checkWallCollision(circle) {
        let collision = false;
        let collisionType = '';
        const workWidth = work.clientWidth;
        const workHeight = work.clientHeight;

        if (circle.x + circleSize > workWidth || circle.x < 0) {
            circle.dx = -circle.dx;
            collision = true;
            collisionType = (circle.x < 0) ? 'LeftWall' : 'RightWall';
            // Коректуємо позицію, щоб об'єкт не застряг
            circle.x = Math.max(0, Math.min(circle.x, workWidth - circleSize));
        }

        if (circle.y + circleSize > workHeight || circle.y < 0) {
            circle.dy = -circle.dy;
            collision = true;
            collisionType = (circle.y < 0) ? 'TopWall' : 'BottomWall';
            // Коректуємо позицію, щоб об'єкт не застряг
            circle.y = Math.max(0, Math.min(circle.y, workHeight - circleSize));
        }
        
        if (collision) {
            logAndSaveEvent('WallCollide', `Дотик до стінки: ${collisionType}`, { wall: collisionType });
        }
        return collision;
    }

    function checkCircleCollision() {
        // Вимірювання відстані між центрами
        const dx = (state.c1.x + circleSize / 2) - (state.c2.x + circleSize / 2);
        const dy = (state.c1.y + circleSize / 2) - (state.c2.y + circleSize / 2);
        const distance = Math.sqrt(dx * dx + dy * dy);
        const minDistance = circleSize; 

        if (distance < minDistance) {
            // Зупиняємо анімацію
            clearInterval(animInterval);
            isMoving = false;
            
            logAndSaveEvent('CirclesCollide', 'Круги зіткнулись! Анімація зупинена.', { distance: distance });
            
            // stop зникає, з'являється reload
            playBtn.style.display = 'none';
            stopBtn.style.display = 'none';
            reloadBtn.style.display = 'inline-block';
            return true;
        }
        return false;
    }
    
    function stopAnimation() {
        clearInterval(animInterval);
        isMoving = false;
        logAndSaveEvent('Stop');
        
        // Після зупинки вручну з'являється start
        playBtn.style.display = 'inline-block';
        stopBtn.style.display = 'none';
        reloadBtn.style.display = 'none';
    }

    function moveAnim() {
        if (!isMoving) return;

        // Рух
        state.c1.x += state.c1.dx;
        state.c1.y += state.c1.dy;
        state.c2.x += state.c2.dx;
        state.c2.y += state.c2.dy;
        
        // Колізії
        checkWallCollision(state.c1);
        checkWallCollision(state.c2);

        // Колізія між кругами
        if (checkCircleCollision()) return;

        // Візуальне оновлення
        circle1.style.left = state.c1.x + 'px';
        circle1.style.top = state.c1.y + 'px';
        circle2.style.left = state.c2.x + 'px';
        circle2.style.top = state.c2.y + 'px';
        
        // Логування кроку руху (Movement Step)
        logAndSaveEvent('MoveStep', 'Крок руху', { c1_pos: `${state.c1.x},${state.c1.y}` });
    }

    function initialize() {
        const workWidth = work.clientWidth;
        const workHeight = work.clientHeight;

        // Початкові позиції (згідно з умовою 2f)
        state.c1.y = Math.random() * (workHeight - circleSize);
        state.c1.x = 0; // Ліва стінка
        
        state.c2.x = Math.random() * (workWidth - circleSize);
        state.c2.y = 0; // Верхня стінка
        
        // Візуальне застосування початкових позицій
        circle1.style.left = state.c1.x + 'px';
        circle1.style.top = state.c1.y + 'px';
        circle2.style.left = state.c2.x + 'px';
        circle2.style.top = state.c2.y + 'px';
        
        // Скидання інтервалу та керування
        clearInterval(animInterval);
        isMoving = false;
        
        // Управління кнопками (Пункт 2g)
        messageBox.textContent = eventsQueue.length > 0 
            ? `Знайдено ${eventsQueue.length} невідправлених подій. Натисніть 'close' або 'start'.`
            : 'Анімація готова. Натисніть "start".';
            
        playBtn.style.display = 'inline-block';
        stopBtn.style.display = 'none';
        reloadBtn.style.display = 'none';
        
        // АКТИВУЄМО КНОПКУ CLOSE!
        closeBtn.disabled = false; 
    }

    // --- 3. ОБРОБНИКИ КНОПОК ---

    playBtn.addEventListener('click', () => {
        if (animInterval) clearInterval(animInterval);
        
        animInterval = setInterval(moveAnim, 16); 
        isMoving = true;
        
        logAndSaveEvent('PlayStart', 'Анімація запущена.');
        
        playBtn.style.display = 'none';
        stopBtn.style.display = 'inline-block';
        reloadBtn.style.display = 'none';
    });

    stopBtn.addEventListener('click', () => {
        stopAnimation();
        logAndSaveEvent('StopPress', 'Анімація зупинена вручну.');
    });

    reloadBtn.addEventListener('click', () => {
        logAndSaveEvent('ReloadPress', 'Перезавантаження: Круги встановлені на нові позиції.');
        initialize();
    });


    // Відправка акумульованих даних та закриття
    closeBtn.addEventListener('click', () => {
        clearInterval(animInterval);
        isMoving = false;
        closeBtn.disabled = true;

        logAndSaveEvent('CloseSession', 'Сесія завершена. Відправка LocalStorage.');
        
        statusBox.textContent = `Відправлення ${eventsQueue.length} накопичених подій...`;
        
        fetch('save_events_accumulated.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ events: eventsQueue })
        })
        .then(response => response.json())
        .then(data => {
            alert(`Дані успішно відправлено! ${data.count || eventsQueue.length} подій. Ви переходите до аналізу логів.`);
            
            // Очищення LocalStorage
            localStorage.removeItem('animationEvents');
            eventsQueue = [];
            eventCounter = 0; 
            
            // --- Перенаправлення на нову сторінку ---
            window.location.href = 'page_logs.php';
        })
        .catch(error => {
            alert('Помилка відправлення LocalStorage! Спробуйте пізніше.');
            console.error('Error:', error);
            initialize(); // Якщо помилка, повертаємося до початкового стану
        });
    });

    // Ініціалізація при завантаженні сторінки
    initialize();
});