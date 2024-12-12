document.addEventListener("DOMContentLoaded", function () {
    const telInput = document.getElementById('tel');

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
});