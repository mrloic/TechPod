<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/Router.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
Router::route($uri);

?>

