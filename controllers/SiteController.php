<?php

/**
 * Контролер SiteController
 */
class SiteController {

    /**
     * Action для показу задач
     */
    public function actionIndex($page = 1) {

        $admin = false;

        if (User::checkLogged()) {
            $admin = true;
        }

        @$bName = $_SESSION['bName'];
        @$bEmail = $_SESSION['bEmail'];
        @$bStatus = $_SESSION['bStatus'];

        // Обробка форми
        if (isset($_POST['sorting'])) {
            $data = $_POST;

            if (isset($data['bName']) && $data['bName'] == '1') {
                $bName = true;
                $_SESSION['bName'] = true;
            } else {
                $bName = false;
                unset($_SESSION['bName']);
            }

            if (isset($data['bEmail']) && $data['bEmail'] == '1') {
                $bEmail = true;
                $_SESSION['bEmail'] = true;
            } else {
                unset($_SESSION['bEmail']);
                $bEmail = false;
            }

            if (isset($data['bStatus']) && $data['bStatus'] == '1') {
                $bStatus = true;
                $_SESSION['bStatus'] = true;
            } else {
                $bStatus = false;
                unset($_SESSION['bStatus']);
            }
        }





        // Список задач
        $tasks = Task::getTasksList($page);

        // Загальна кількість задач необхідних для навігації
        $total = Task::getTotalTasks();

        // Створємо об'єкт Pagination - сторінкова навігація
        $pagination = new Pagination($total, $page, Task::SHOW_BY_DEFAULT, 'page-');

        // Підключаємо вид
        require_once(ROOT . '/views/site/tasks.php');
        return true;
    }

    /**
     * Action для додавання задач
     */
    public function actionAdd() {

        $admin = false;

        if (User::checkLogged()) {
            $admin = true;
        }

        $result = false;

        // Обробка форми
        if (isset($_POST['add_task'])) {
            // Якщо форма відправлена - отримуємо дані

            $data = $_POST;

            $options = [];
            $options['name'] = $data['name'];
            $options['email'] = $data['email'];
            $options['text'] = $data['task'];

            // Масив помилок
            $errors = false;

            // Валідація полів
            if (!Task::checkName($options['name'])) {
                $errors[] = 'Ім\'я не повинно бути коротше за 3 символи!';
            }

            if (!Task::checkEmail($options['email'])) {
                $errors[] = 'Неправильний email!';
            }

            if ($errors == false) {
                // Якщо помилок немає - додаємо нову задачу
                $id = Task::addTask($options);

                // Якщо запис додано 
                if ($id) {
                    $result = $id;
                };
            }
        }

        // Підключаємо вид
        require_once(ROOT . '/views/site/add.php');
        return true;
    }

}
