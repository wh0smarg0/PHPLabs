// anim_logs.js
document.addEventListener("DOMContentLoaded", () => {
    const logImmediateContainer = document.getElementById('logImmediate');
    const logLocalStorageContainer = document.getElementById('logLocalStorage');

    function displayLogsFromServer() {
        fetch('get_events_for_display.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'error') {
                    logImmediateContainer.innerHTML = '<h4>Помилка БД:</h4><p>' + data.message + '</p>';
                    return;
                }
                
                // Якщо даних немає
                if (!data.events || data.events.length === 0) {
                     logImmediateContainer.innerHTML += '<p>Логи відсутні.</p>';
                     logLocalStorageContainer.innerHTML += '<p>Логи відсутні.</p>';
                     return;
                }
                
                let htmlImm = '<table class="log-table"><tr><th>ID</th><th>Event</th><th>Local Time</th><th>Server Time</th></tr>';
                let htmlLS = '<table class="log-table"><tr><th>ID</th><th>Event</th><th>Local Time</th></tr>';
                
                data.events.forEach(e => {
                    const localTimeStr = e.local_time ? e.local_time.slice(11, 19) : 'N/A';
                    const serverTimeStr = e.server_time ? e.server_time.slice(11, 19) : 'N/A';

                    if (e.method === 'Immediate') {
                        htmlImm += `<tr><td>${e.event_id}</td><td>${e.type}</td><td>${localTimeStr}</td><td>${serverTimeStr}</td></tr>`;
                    } else if (e.method === 'LocalStorage') {
                        htmlLS += `<tr><td>${e.event_id}</td><td>${e.type}</td><td>${localTimeStr}</td></tr>`;
                    }
                });

                htmlImm += '</table>';
                htmlLS += '</table>';
                
                // Показуємо повідомлення, якщо відображено не всі записи
                let infoMsg = '';
                if (data.count > data.displayed) {
                    infoMsg = `<p style="color:#feca57; font-size:12px;">(Показано останні ${data.displayed} із ${data.count} записів для швидкодії)</p>`;
                }

                logImmediateContainer.innerHTML = `<h4>Immediate Log (Всього: ${data.count})</h4>${infoMsg}` + htmlImm;
                logLocalStorageContainer.innerHTML = `<h4>LocalStorage Log</h4>` + htmlLS;
            })
            .catch(err => {
                 console.error(err);
                 logImmediateContainer.innerHTML = '<h4>Помилка</h4><p>Не вдалося завантажити логи.</p>';
            });
    }

    displayLogsFromServer();
});