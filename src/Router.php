<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'App.php';
require_once 'API.php';

class Router {
    public static function route($uri) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Проверяем сессию перед выбором маршрута
        if (!isset($_SESSION['token']) && $uri !== '/login' && $uri !== '/process_login') {
            header('Location: /login');
            exit;
        }
        
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
            
            case '/api/employees':
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    header('Content-Type: application/json');
            
                    // Получаем данные сотрудников из API
                    try {
                        $data = fetchApiData('employees.get_all', null, 'GET', null, $_SESSION['token']);
                        if ($data) {
                            echo json_encode($data);
                        } else {
                            http_response_code(500);
                            echo json_encode(['error' => 'Ошибка получения данных сотрудников']);
                        }
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo json_encode(['error' => $e->getMessage()]);
                    }
                } else {
                    http_response_code(405);
                    echo json_encode(['error' => 'Метод не поддерживается']);
                }
                break;
                
            case '/api/add_task':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    header('Content-Type: application/json');
                    $input = json_decode(file_get_contents('php://input'), true);
            
                    if (!isset($input['description'], $input['status'])) {
                        http_response_code(400);
                        echo json_encode(['error' => 'Некорректные данные']);
                        exit;
                    }
            
                    try {
                        $result = fetchApiData(
                            'work.add',
                            null,
                            'POST',
                            [
                                'description' => $input['description'],
                                'status' => $input['status']
                            ],
                            $_SESSION['token']
                        );
            
                        if ($result) {
                            echo json_encode($result);
                        } else {
                            http_response_code(500);
                            echo json_encode(['error' => 'Ошибка добавления задачи']);
                        }
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo json_encode(['error' => $e->getMessage()]);
                    }
                } else {
                    http_response_code(405);
                    echo json_encode(['error' => 'Метод не поддерживается']);
                }
                break;
                
            default:
                http_response_code(404);
                $app->render('404.html.twig', ['title' => 'Ошибка 404']);
        }
    }
}

?>