// Константы
const SELECTORS = {
    PROFILE: '.profile_logo',
    SIDEBAR: '.sidebar',
    SIDEBAR_CLOSE: '.close_sidebar',
    SIDEBAR_LIST: '.sidebar_list',
    ADD_EMPLOYEE: '.add_employee',
    MODALS: {
        ADD: '#addEmployeeModal',
        EDIT: '#editEmployeeModal'
    }
};

// Класс для работы с сотрудниками
class EmployeeManager {
    constructor() {
        this.cache = null;
        this.sidebarList = document.querySelector(SELECTORS.SIDEBAR_LIST);
        this.editModal = document.querySelector(SELECTORS.MODALS.EDIT);
    }

    async fetchEmployees() {
        if (this.cache) return this.cache;

        this.sidebarList.innerHTML = '<li>Загрузка...</li>';
        
        try {
            const response = await fetch("/api/employees");
            const employees = await response.json();
            this.cache = employees;
            return employees;
        } catch (error) {
            console.error("Ошибка получения данных:", error);
            throw error;
        }
    }

    async updateEmployeesList() {
        try {
            const employees = await this.fetchEmployees();
            this.sidebarList.innerHTML = '';
            
            employees.forEach(employee => {
                const li = this.createEmployeeListItem(employee);
                this.sidebarList.appendChild(li);
            });
        } catch {
            this.sidebarList.innerHTML = '<li>Ошибка загрузки сотрудников</li>';
        }
    }

    createEmployeeListItem(employee) {
        const li = document.createElement("li");
        li.textContent = `${employee.first_name} ${employee.last_name} ${employee.middle_name || ''}`;
        
        const editButton = document.createElement("button");
        const editIcon = document.createElement("img");
        editIcon.src = "/media/img/edit.svg";
        editIcon.alt = "Редактировать";
        editButton.appendChild(editIcon);
        editButton.classList.add("edit_button");
        editButton.addEventListener("click", () => this.showEditModal(employee));
        
        li.appendChild(editButton);
        return li;
    }

    async handleFormSubmit(form, url, method) {
        const formData = new FormData(form);
        const jsonData = Object.fromEntries(formData.entries());

        try {
            const response = await fetch(url, {
                method,
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(jsonData)
            });

            if (response.ok) {
                this.cache = null; // Сбрасываем кэш
                await this.updateEmployeesList();
                return true;
            }
            return false;
        } catch (error) {
            console.error(`Ошибка ${method === 'POST' ? 'добавления' : 'редактирования'} сотрудника:`, error);
            return false;
        }
    }

    showEditModal(employee) {
        if (!this.editModal) return;
        
        // Заполняем форму данными сотрудника
        const form = this.editModal.querySelector('form');
        if (form) {
            form.querySelector('input[name="id"]').value = employee.id;
            form.querySelector('input[name="first_name"]').value = employee.first_name;
            form.querySelector('input[name="last_name"]').value = employee.last_name;
            form.querySelector('input[name="email"]').value = employee.email;
            form.querySelector('input[name="phone"]').value = employee.phone;

            // Добавляем обработчик отправки формы
            form.onsubmit = async (e) => {
                e.preventDefault();
                const success = await this.handleFormSubmit(
                    form,
                    `/api/employees/${employee.id}`,
                    'PUT'
                );
                if (success) {
                    this.editModal.style.display = 'none';
                }
            };
        }

        // Показываем модальное окно
        this.editModal.style.display = 'flex';
    }
}

// Класс для управления модальными окнами
class ModalManager {
    constructor(employeeManager) {
        this.employeeManager = employeeManager;
        this.initializeModals();
    }

    initializeModals() {
        // Инициализация модальных окон и обработчиков
        const addModal = document.querySelector(SELECTORS.MODALS.ADD);
        const editModal = document.querySelector(SELECTORS.MODALS.EDIT);

        if (addModal && editModal) {
            this.setupModalHandlers(addModal, editModal);
        }
    }

    setupModalHandlers(addModal, editModal) {
        // Настройка обработчиков событий для модальных окон
        document.querySelector(SELECTORS.ADD_EMPLOYEE)
            ?.addEventListener("click", () => addModal.style.display = "flex");

        document.querySelectorAll('.close_modal').forEach(button => {
            button.addEventListener("click", () => {
                addModal.style.display = "none";
                editModal.style.display = "none";
            });
        });

        // Добавляем обработчик клика вне модального окна
        window.addEventListener('click', (e) => {
            if (e.target === addModal) addModal.style.display = 'none';
            if (e.target === editModal) editModal.style.display = 'none';
        });

        // Добавляем обработчик клавиши Escape
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                addModal.style.display = 'none';
                editModal.style.display = 'none';
            }
        });
    }
}

// Инициализация при загрузке DOM
document.addEventListener("DOMContentLoaded", () => {
    const employeeManager = new EmployeeManager();
    const modalManager = new ModalManager(employeeManager);

    // Инициализация сайдбара
    const sidebar = document.querySelector(SELECTORS.SIDEBAR);
    const profileLogo = document.querySelector(SELECTORS.PROFILE);
    
    if (sidebar && profileLogo) {
        profileLogo.addEventListener("click", () => {
            sidebar.classList.add("show");
            employeeManager.updateEmployeesList();
        });

        // Закрытие сайдбара
        document.querySelector(SELECTORS.SIDEBAR_CLOSE)
            ?.addEventListener("click", () => sidebar.classList.remove("show"));

        // Закрытие при клике вне сайдбара
        document.addEventListener("click", (e) => {
            if (!sidebar.contains(e.target) && !profileLogo.contains(e.target)) {
                sidebar.classList.remove("show");
            }
        });
    }
});
