<?php

require_once '../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class App {
    private $twig;

    public function __construct() {
        $loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader, [
            'cache' => '../cache',
            'auto_reload' => true,
        ]);
    }

    public function render($template, $data = []) {
        echo $this->twig->render($template, $data);
    }
}
?>