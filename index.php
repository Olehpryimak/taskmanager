<?php

// FRONT CONTROLLER

// Загальні налаштування
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

// Підключення файлів системи
define('ROOT', dirname(__FILE__));
require './vendor/autoload.php';
require_once(ROOT.'/components/Autoload.php');
require_once ('./config/db_params.php');


// Виклик Router
$router = new Router();
$router->run();
