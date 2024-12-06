// const addCardBtn = document.getElementById('addCardBtn');
// const taskModal = document.getElementById('taskModal');


// addCardBtn.addEventListener('click', () => {
//     taskModal.style.display = 'flex';
// });
const apiUrl = 'http://127.0.0.1:8801/api/WorkItems/GetWork';

async function fetchAndDisplayTasks() {
    try {
        // Отправляем запрос
        const response = await fetch(apiUrl);

        // Проверяем, успешен ли запрос
        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        // Преобразуем ответ в JSON
        const data = await response.json();

        // Контейнер для вывода задач
        const tasksContainer = document.getElementById('board');

        // Отображаем данные
        data.forEach(task => {
            // Создаем элемент для каждой задачи
            const taskElement = document.createElement('div');
            taskElement.className = 'card';
            // taskElement.style.border = '1px solid #ccc';
            // taskElement.style.margin = '10px';
            // taskElement.style.padding = '10px';

            // Заполняем данными
            taskElement.innerHTML = `
                <div class="hr"></div>
                <span class="card-span">${task.work_number}</span>
                <div class="profile_card">
                    <img src="media/img/profile.svg" alt="profile" class="profile_img">
                    <div class="date">
                        <span>${new Date(task.time_limit).toLocaleString()}</span>
                    </div>
                </div>
            `;

            // taskElement.innerHTML = `
            //             <p><strong>ID:</strong> ${task.id}</p>
            //             <p><strong>Номер задачи:</strong> ${task.work_number}</p>
            //             <p><strong>Описание:</strong> ${task.description}</p>
            //             <p><strong>Статус:</strong> ${task.status}</p>
            //             <p><strong>Срок:</strong> ${new Date(task.time_limit).toLocaleString()}</p>
            //             <p><strong>Картинка:</strong> <img src="${task.image}" alt="Image" style="max-width: 100px;"></p>
            //         `;

            // Добавляем в контейнер
            tasksContainer.appendChild(taskElement);
        });
    } catch (error) {
        console.error('Ошибка получения данных:', error);
    }
}

// Вызываем функцию
fetchAndDisplayTasks();