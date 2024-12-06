<?php

require_once 'App.php';

class Router {
    public static function route($uri) {
        $app = new App();

        switch ($uri) {
            case '/':
                $app->render('main.html.twig', ['title' => 'Главная страница']);
                break;

            case '/about':
                $app->render('base.html.twig', ['title' => 'О проекте']);
                break;

            default:
                http_response_code(404);
                $app->render('base.html.twig', ['title' => 'Ошибка 404', 'content' => 'Страница не найдена.']);
        }
    }
}

?>