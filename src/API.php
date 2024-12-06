<?php
function fetchApiData($url) {
    // Используем cURL для выполнения запроса
    $ch = curl_init();
    
    // Настройки cURL
    curl_setopt($ch, CURLOPT_URL, $url);          // Устанавливаем URL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Возвращать ответ в виде строки
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',       // Устанавливаем заголовок
    ]);
    
    $response = curl_exec($ch); // Выполняем запрос
    
    if (curl_errno($ch)) {
        echo 'Ошибка cURL: ' . curl_error($ch); // Обрабатываем ошибки
        curl_close($ch);
        return null;
    }
    
    curl_close($ch);
    
    // Декодируем JSON
    $data = json_decode($response, true);
    
    return $data;
}

function formatDate($dateString) {
    // Убираем лишние символы, если есть (например, "T" и миллисекунды)
    $dateString = preg_replace('/\.\d+/', '', str_replace('T', ' ', $dateString));
    
    try {
        $date = new DateTime($dateString);
        // Возвращаем в нужном формате: "дд МММ"
        return $date->format('d M'); // d - день, M - короткое название месяца
    } catch (Exception $e) {
        return "Неверный формат даты"; // Если формат некорректен
    }
}

function formatDateRus($dateString) {
    // Массив месяцев на русском
    $months = [
        'Jan' => 'янв.', 'Feb' => 'фев.', 'Mar' => 'мар.', 'Apr' => 'апр.',
        'May' => 'мая', 'Jun' => 'июн.', 'Jul' => 'июл.', 'Aug' => 'авг.',
        'Sep' => 'сен.', 'Oct' => 'окт.', 'Nov' => 'нояб.', 'Dec' => 'дек.'
    ];

    // Убираем лишние символы
    $dateString = preg_replace('/\.\d+/', '', str_replace('T', ' ', $dateString));
    
    try {
        $date = new DateTime($dateString);
        $day = $date->format('d');
        $monthEng = $date->format('M'); // Получаем короткое название месяца на английском
        $monthRus = $months[$monthEng] ?? $monthEng; // Переводим на русский

        return "{$day} {$monthRus}";
    } catch (Exception $e) {
        return "Неверный формат даты";
    }
}

function getBackgroundClass($formattedDate) {
    // Устанавливаем часовой пояс для сравнения (например, UTC)
    $timezone = new DateTimeZone('Asia/Yekaterinburg');

    // Преобразуем строку даты в объект DateTime
    $date = DateTime::createFromFormat('d M', $formattedDate, $timezone);

    // Проверяем, удалось ли создать объект
    if (!$date) {
        error_log("Ошибка: Неверный формат даты: $formattedDate");
        return 'bg-error'; // Класс ошибки
    }

    // Устанавливаем текущий год, так как в формате его нет
    $date->setDate((int)date('Y'), $date->format('m'), $date->format('d'));
    $date->setTime(0, 0, 0);

    // Получаем текущую дату в том же часовом поясе
    $today = new DateTime('now', $timezone);
    $today->setTime(0, 0, 0); // Сбрасываем время для точного сравнения

    // var_dump("date --==",$date, "today --==", $today);

    if ($date == $today) {
        return 'bg-today'; // Сегодня
    } elseif ($date < $today) {
        return 'bg-past'; // В прошлом
    } else {
        return 'bg-future'; // В будущем
    }
}
?>