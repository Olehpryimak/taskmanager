<?php

/**
 * Контролер AdminController
 */
class AdminController {

    /**
     * Action для авторизації
     */
    public function actionLogin() {

        // Якщо користувач уже залогінився - виходимо
        if (User::checkLogged()) {
            User::delSession();
        }

        // Змінні для форми
        $login = false;
        $password = false;

        // Масив помилок
        $errors = false;

        if (isset($_POST['do_login'])) {
            // Якщо форма відправлена- отримуємо дані
            $data = $_POST;

            $login = $data['login'];
            $password = $data['password'];



            // Перевіряємо чи існує користувач
            $userId = User::checkUserData($login, $password);

            if ($userId == false) {
                // Якщо дані не правильні - показуємо помилку
                $errors[] = 'Неправильні дані для входу на сайт';
            } else {
                // Інакше, запам'ятовуємо користувача
                User::auth($userId);

                // Перенаправляємо користувача на основну сторінку
                header("Location: /");
            }
        }

        // Підключаємо вид
        require_once(ROOT . '/views/admin/login.php');
        return true;
    }

    /**
     * Видаляємо дані про користувача з сесії
     */
    public function actionLogout() {
        // Видаляємо дані із сесії
        User::delSession();

        // Перенаправляємо користувача на головну сторінку
        header("Location: /");
    }

    /**
     * Видаляємо дані про користувача з сесії
     */
    public function actionEdit($taskId) {

        if (!User::checkLogged()) {
            $admin = true;
        }

        // Отримуємо дані про конкретну задачу
        $task = Task::getTaskById($taskId);

        // Обробка форми
        if (isset($_POST['edit'])) {
            // Якщо форма відправлена - отримуємо дані
            $data = $_POST;

            $id = $taskId;
            $text = $data['text'];
            if (isset($data['edited']) && $data['edited'] == '1') {
                $isChecked = true;
            } else {
                $isChecked = false;
            }

            // Зберігаємо зміни
            Task::updateTaskById($id, $text, $isChecked);

            // Перенаправляємо користувача на головну
            header("Location: /");
        }

        // Підключаємо вид
        require_once(ROOT . '/views/admin/edit.php');
        return true;
    }

}
