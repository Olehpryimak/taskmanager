<?php

/**
 * Функція __autoload для автоматичного підключення класів
 */
function my_autoloader($class_name)
{
    // Масив папок, в яких можуть знаходитися необхідні класи
    $array_paths = array(
        '/models/',
        '/components/',
        '/controllers/',
    );

    // Проходимо по масиву папок
    foreach ($array_paths as $path) {

        // Формуємо ім'я і шлях до файлу з класом
        $path = ROOT . $path . $class_name . '.php';

        // Якщо такий файл існує - підключаємо його
        if (is_file($path)) {
            include_once $path;
        }
    }
}

spl_autoload_register('my_autoloader');
