<?php

require_once 'App.php';
session_start();

// Убедимся, что это POST-запрос
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Метод не поддерживается!');
}

// Получаем данные из формы
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Проверяем заполненность
if (empty($username) || empty($password)) {
    $error = 'Имя пользователя и пароль обязательны!';
    (new App())->render('login.html.twig', ['title' => 'Вход', 'error' => $error]);
    exit;
}

// Данные для API
$apiUrl = 'http://localhost:8801/api/JWT/login';
$postData = json_encode([
    'Username' => $username,
    'Password' => $password,
    'model' => 'some_value'
]);

// Инициализируем cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

// Выполняем запрос
$response = curl_exec($ch);
if ($response === false) {
    $error = 'Ошибка соединения с сервером: ' . curl_error($ch);
    curl_close($ch);
    (new App())->render('login.html.twig', ['title' => 'Вход', 'error' => $error]);
    exit;
}

curl_close($ch);

// Обработка ответа
$responseData = json_decode($response, true);
if (isset($responseData['token'])) {
    $_SESSION['token'] = $responseData['token'];
    header('Location: /'); // Перенаправляем на главную страницу
    exit;
} else {
    $error = $responseData['error'] ?? 'Неверные учетные данные!';
    (new App())->render('login.html.twig', ['title' => 'Вход', 'error' => $error]);
    exit;
}
?>