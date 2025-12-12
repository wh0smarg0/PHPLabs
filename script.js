document.addEventListener("DOMContentLoaded", () => {
    const pageStart = performance.now();

    // Визначаємо унікальне ім'я сторінки
    const pageName = document.body.dataset.page || window.location.pathname.split("/").pop();

    // Створюємо таймер на сторінці
    const timerDiv = document.createElement('div');
    timerDiv.style.position = 'fixed';
    timerDiv.style.bottom = '10px';
    timerDiv.style.right = '10px';
    timerDiv.style.background = 'rgba(0,0,0,0.6)';
    timerDiv.style.color = '#feca57';
    timerDiv.style.padding = '5px 10px';
    timerDiv.style.borderRadius = '8px';
    timerDiv.style.fontSize = '14px';
    timerDiv.style.zIndex = '1000';
    document.body.appendChild(timerDiv);

    const editableBlocks = document.querySelectorAll('.left, .main, .right-top, .right-bottom, .footer');

    editableBlocks.forEach(block => {
        // Ключ тепер унікальний для кожного блоку на конкретній сторінці
        const key = `content-${pageName}-${block.className}`;

        // Підстановка з localStorage
        const t0 = performance.now();
        const saved = localStorage.getItem(key);
        if (saved) block.innerHTML = saved;
        const t1 = performance.now();
        console.log(`Час підстановки localStorage для ${block.className} на ${pageName}: ${(t1 - t0).toFixed(2)} ms`);

        // Натискання для редагування
        block.addEventListener('click', () => {
            block.contentEditable = "true";
            block.focus();
            block.style.outline = "2px dashed #feca57";
        });

        // Зберігаємо зміни при виході з блоку
        block.addEventListener('blur', () => {
            block.contentEditable = "false";
            block.style.outline = "";
            localStorage.setItem(key, block.innerHTML);
        });
    });

    const pageEnd = performance.now();
    const totalTime = (pageEnd - pageStart).toFixed(2);
    console.log(`Час формування сторінки + підстановка localStorage на ${pageName}: ${totalTime} ms`);

    // Відображення на сторінці
    timerDiv.innerText = `Час завантаження сторінки: ${totalTime} ms`;
});
