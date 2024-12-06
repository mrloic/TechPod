<?php

require_once 'App.php';
require_once 'API.php';

class Router {
    public static function route($uri) {
        $app = new App();

        $url = "http://localhost:8801/api/WorkItems/GetWork";
        $data = fetchApiData($url);

        foreach ($data as &$item) {
            $item['formatted_time_limit'] = formatDate($item['time_limit']);
            $item['formatted_time_limit_rus'] = formatDateRus($item['time_limit']);
            $item['background_class'] = getBackgroundClass($item['formatted_time_limit']);
        }
        unset($item);

        switch ($uri) {
            case '/':
                $app->render('main.html.twig', ['title' => 'Главная страница', 'work_items' => $data]);
                break;

            case '/about':
                $app->render('base.html.twig', ['title' => 'О проекте']);
                break;

            default:
                http_response_code(404);
                $app->render('404.html.twig', ['title' => 'Ошибка 404', 'content' => 'Страница не найдена.']);
        }
    }
}

?>