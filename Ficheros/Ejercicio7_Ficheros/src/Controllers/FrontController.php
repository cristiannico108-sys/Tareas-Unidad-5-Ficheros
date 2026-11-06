<?php
declare(strict_types=1);

namespace Controllers;

class FrontController
{
    public static function main(): void
    {

        $controller_name = $_GET['controller'] ?? CONTROLLER_DEFAULT;
        $action_name = $_GET['action'] ?? ACTION_DEFAULT;

        $nombre_controlador = 'Controllers\\' . ucfirst($controller_name) . 'Controller';

        if (
            !class_exists($nombre_controlador)
            || in_array($nombre_controlador, [self::class, ErrorController::class], true)
        ) {
            ErrorController::show_error404();
            return;
        }

        $controlador = new $nombre_controlador();

        if (is_callable([$controlador, $action_name])) {
            $controlador->$action_name();
        } else {
            ErrorController::show_error404();
        }
    }

}