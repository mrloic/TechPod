<?php

require_once 'App.php';
require_once 'API.php';

class Router {
    public static function route($uri) {
        session_start();
        $app = new App();

        switch ($uri) {
            case '/':
                $data = fetchApiData('work.get_all', null, 'GET', null, $_SESSION['token']);
                if (!is_array($data)) {
                    $data = []; // Устанавливаем пустой массив, если данные некорректны
                    error_log('Получены некорректные данные из API');
                }
        
                foreach ($data as &$item) {
                    $item['formatted_time_limit'] = formatDate($item['time_limit']);
                    $item['formatted_time_limit_rus'] = formatDateRus($item['time_limit']);
                    $item['background_class'] = getBackgroundClass($item['formatted_time_limit']);
                }
                unset($item);

                if (!isset($_SESSION['token'])) {
                    header('Location: /login');
                    exit;
                }
                $app->render('main.html.twig', [
                    'title' => 'Главная страница',
                    'work_items' => $data,
                    'error' => empty($data) ? 'Не удалось загрузить данные. Попробуйте позже.' : null,
                ]);
                break;

            case '/login':
                $app->render('login.html.twig', ['title' => 'Вход']);
                break;

            case '/process_login':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    require_once 'process_login.php';
                } else {
                    http_response_code(405); // Метод не поддерживается
                    $app->render('405.html.twig', ['title' => 'Метод не поддерживается']);
                }
                break;

            default:
                http_response_code(404);
                $app->render('404.html.twig', ['title' => 'Ошибка 404']);
        }
    }
}

?>