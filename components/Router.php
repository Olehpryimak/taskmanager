<?php

/**
 * Клас Router
 * Компонент для работи з маршрутами
 */
class Router {

    /**
     * Атрибут для зберігання масива роутів
     * @var array 
     */
    private $routes;

    /**
     * Конструктор
     */
    public function __construct() {
        // Шлях до файлу з роутами
        $routesPath = ROOT . '/config/routes.php';

        // Отримуємо роути із файла
        $this->routes = include($routesPath);
    }

    /**
     * Повертає строку запиту
     */
    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * Метод для обробки запиту
     */
    public function run() {
        // Отримуємо строку запиту
        $uri = $this->getURI();

        // Перевіряємо наявність такого запиту в маршрутах (routes.php)
        foreach ($this->routes as $uriPattern => $path) {

            // Порівнюємо $uriPattern і $uri
            if (preg_match("~$uriPattern~", $uri)) {



                // Отримуємо внутрішній шлях із зовнішнього за правилом.
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Визначити контролер, action, параметри

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                // Підключити файл класа-контролера
                $controllerFile = ROOT . '/controllers/' .
                        $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                // Створити об'єкт, викликати метод (action)
                $controllerObject = new $controllerName;

                /* Викликаємо необхідний метод ($actionName) у визначеного 
                 * класу ($controllerObject) з заданими ($parameters) параметрами
                 */
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                // var_dump($controllerObject);
                // Якщо метод контролера успішно викликаний, завершаємо роботу роутера
                if ($result != null) {
                    break;
                }
            }
        }
    }

}
