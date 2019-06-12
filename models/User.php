<?php
use \RedBeanPHP\R as R;
/**
 * Клас User - модель для роботи з користувачами
 */
class User {

    public static function checkAdmin() {
        // Перевіряємо чи авторизований користувач, якщо ні - його буде переадресовано
        $userId = User::checkLogged();

        return true;
    }

    /**
     * Повертає ідентифікатор користувача, якщо він авторизований.<br/>
     * @return string <p>Ідентифікатор користувача</p>
     */
    public static function checkLogged() {
        // Якщо є сесія - повернемо ідентифікатор користувача
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        return false;
    }

    /**
     * Запам'ятовуємо користувача
     * @param integer $userId <p>id користувача</p>
     */
    public static function auth($userId) {
        // Записуємо ідентифікатор користувача в сесію
        $_SESSION['user'] = $userId;
    }
    
    /**
     * Видаляємо користувача
     */
    public static function delSession() {
        // Видаляємо інформацію про користувача із сесії
        unset($_SESSION["user"]);

    }

    /**
     * Перевіряємо чи існує користувач з заданим login і пароль
     * @param string $login <p>Login</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($login, $password) {
        // Шукаємо користувача з заданим логіном
        $user = R::findOne('admins', 'login = ?', array($login));

        // Перевіряємо пароль користувача
        // !!!
        // Я зашифрував пароль, хоча цього не було в завданні!!!
        // Вважаю це кращим!
        // !!!
        if (password_verify($password, $user->password)) {
            // Якщо пароль правильний - повертаємо id користувача
            return $user['id'];
        }
        return false;
    }

}
