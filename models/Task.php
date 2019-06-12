<?php
use \RedBeanPHP\R as R;
/**
 * Клас Task - модель для роботи з товарами
 */
class Task {

    // Кількість відображаємих товарів за замовчуванням
    const SHOW_BY_DEFAULT = 3;

    /**
     * Повертає список задач
     * @param type $page [optional] <p>Номер сторінки</p>
     * @return type <p>Масив задач</p>
     */
    public static function getTasksList($page = 1) {
        $limit = Task::SHOW_BY_DEFAULT;
        // Зсув (для SQL запиту)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        $r = Task::getSQLSorting();
        
        // Запит до БД
        $tasks = R::getAll('SELECT id, email, text, user, is_checked FROM `tasks` ORDER BY '.$r.' ASC LIMIT ? OFFSET ?', array(
                    $limit,
                    $offset
        ));
        return $tasks;
    }

    /**
     * Повертає атрибути за якими будуть сортуватися задачі 
     * @return type <p>Змінна з атрибутами для сортування</p>
     */
    private static function getSQLSorting() {
        
        $others = false;
        $attrib = "";
        if (isset($_SESSION['bName'])) {
            $attrib .="user";
            $others = true;
        }
        
        if (isset($_SESSION['bEmail'])) {
            
            $attrib .= $others ? ", email" : "email";
            $others = true;
            
        }
        
        if (isset($_SESSION['bStatus'])) {
            
            $attrib .= $others ? ", is_checked" : "is_checked";
            $others = true;
        }
        
        $attrib .= $others ? "" : "id";
        
        return $attrib;
    }

    /**
     * Повертаємо кількість задач
     * @return integer
     */
    public static function getTotalTasks() {


        // Запит до БД
        $result = R::getRow('SELECT count(id) AS count FROM tasks');

        return $result['count'];
    }

    /**
     * Проверяет ім'я: не менше, ніж 3 символи
     * @param string $name <p>Ім'я</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkName($name) {
        if (iconv_strlen($name) >= 3) {
            return true;
        }
        return false;
    }

    /**
     * Перевіряє email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Додоємо нову задачу
     * @param array $options <p>Масив з інформацією про задачу</p>
     * @return integer <p>id доданого в таблицю запису</p>
     */
    public static function addTask($options) {
        // Запит до БД
        $user = R::dispense('tasks');
        $user->user = $options['name'];
        $user->text = $options['text'];
        $user->email = $options['email'];
        $result = R::store($user);

        // Повертаємо результат
        return $result;
    }

    /**
     * Повертає задачу з вказаним id 
     * @param integer $id <p>id</p>
     * @return array <p>Масив з інформацією про задачу</p>
     */
    public static function getTaskById($id) {
        // Запит до бд
        $task = R::findOne('tasks', 'id = ?', array($id));

        return $task;
    }

    /**
     * Редагує задачу з заданим id
     * @param integer $id <p>id задачі</p>
     * @param string $text <p>Текст задачі</p>
     * @param string $isChecked <p>Статус задачі</p>
     * @return boolean <p>Результат виконання методу</p>
     */
    public static function updateTaskById($id, $text, $isChecked) {

        // Запит до бд
        $task = R::load('tasks', $id);
        $task->text = $text;
        $task->is_checked = $isChecked;

        return R::store($task);
    }

}
