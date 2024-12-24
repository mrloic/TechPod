document.addEventListener("DOMContentLoaded", function () {
    const telInput = document.getElementById('tel');

    if (telInput) {
        telInput.addEventListener('input', function () {
            let value = telInput.value.replace(/\D/g, ''); // Удаляем всё, кроме цифр

            // Ограничиваем количество цифр до 10 (без учета "+7")
            if (value.startsWith('7')) {
                value = value.slice(1);
            }
            value = value.slice(0, 10);

            // Применяем маску
            let formattedValue = '+7';
            if (value.length > 0) {
                formattedValue += ' (' + value.slice(0, 3);
            }
            if (value.length >= 4) {
                formattedValue += ') ' + value.slice(3, 6);
            }
            if (value.length >= 7) {
                formattedValue += '-' + value.slice(6, 8);
            }
            if (value.length >= 9) {
                formattedValue += '-' + value.slice(8, 10);
            }

            telInput.value = formattedValue;
        });
    }

    const profile = document.querySelector('.profile');
    const sideMenu = document.getElementById('sideMenu');
    const addEmployeeBtn = document.getElementById('addEmployeeBtn');
    const employeeList = document.getElementById('employeeList');

    profile.addEventListener('click', () => {
        sideMenu.classList.toggle('hidden');
        loadEmployees();
    });

    // Добавляем делегирование событий для кнопок редактирования
    employeeList.addEventListener('click', (e) => {
        if (e.target.closest('.menu_btn')) {
            const li = e.target.closest('li');
            // Здесь добавьте логику редактирования
            console.log('Редактирование сотрудника');
        }
    });

    async function loadEmployees() {
        try {
            const response = await fetch('/api/employees');
            if (!response.ok) {
                throw new Error('Ошибка загрузки данных');
            }
            const employees = await response.json();

            employeeList.innerHTML = employees.map(employee => `
                <li data-employee-id="${employee.id}">
                    <span>${employee.last_name} ${employee.first_name}</span>
                    <button class="menu_btn">
                        <img src="/media/img/edit_employee.svg" alt="Редактировать">
                    </button>
                </li>
            `).join('');
        } catch (error) {
            console.error('Ошибка при загрузке сотрудников:', error);
            employeeList.innerHTML = '<li>Ошибка при загрузке данных</li>';
        }
    }

    const addCardBtn = document.getElementById('addCardBtn');
    const addTaskModal = document.getElementById('addTaskModal');
    const addTaskForm = document.getElementById('addTaskForm');

    addCardBtn.addEventListener('click', () => {
        addTaskModal.classList.remove('hidden');
    });

    addTaskForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const description = addTaskForm.description.value;
        const response = await fetch('/api/work', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                description,
                status: 'unassembled'
            })
        });

        if (response.ok) {
            alert('Задача добавлена');
            addTaskModal.classList.add('hidden');
        } else {
            alert('Ошибка добавления задачи');
        }
    });
});

document.querySelectorAll('.board_btn img[alt="plus"]').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        const board = e.target.closest('.board');
        const status = board.querySelector('.head_board span').textContent.trim();

        const statusMap = {
            'Неразобранное': 'unassembled',
            'Выполняется': 'work',
            'Готово': 'done'
        };

        const response = await fetch('/api/work', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                description: 'Новая задача',
                status: statusMap[status]
            })
        });

        if (response.ok) {
            alert('Задача добавлена');
        } else {
            alert('Ошибка добавления задачи');
        }
    });
});
