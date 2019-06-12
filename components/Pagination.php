<?php

/*
 * Клас Pagination для генерації сторінкової навигації
 */

class Pagination
{

    /**
     * 
     * @var Посилань навігації на сторінки
     * 
     */
    private $max = 10;

    /**
     * 
     * @var Ключ для GET, в якій пишеться номер сторінки
     * 
     */
    private $index = 'page';

    /**
     * 
     * @var Поточна сторінка
     * 
     */
    private $current_page;

    /**
     * 
     * @var Загальна кількість записів
     * 
     */
    private $total;

    /**
     * 
     * @var Записів на сторінці
     * 
     */
    private $limit;

    /**
     * Запуск необхідних даних для навигації
     * @param type $total <p>Загальна кількість записів</p>
     * @param type $currentPage <p>Номер поточної сторінки</p>
     * @param type $limit <p>Кількість записів на сторінку</p>
     * @param type $index <p>Ключ для url</p>
     */
    public function __construct($total, $currentPage, $limit, $index)
    {
        # Встановлюємо загальну кількість записів
        $this->total = $total;

        # Встановлюємо кількість записів на сторінку
        $this->limit = $limit;

        # Встановлюємо ключ в url
        $this->index = $index;

        # Встановлюємо кількість сторінок
        $this->amount = $this->amount();
        
        # Встановлюємо номер поточної сторінки
        $this->setCurrentPage($currentPage);
    }

    /**
     *  Для вивода посилань
     * @return HTML-код з посиланнями навигації
     */
    public function get()
    {
        # Для запису посилань
        $links = null;

        # Отримуємо ліміт для циклу
        $limits = $this->limits();
        
        $html = '<ul class="pagination">';
        # Генеруємо посилання
        for ($page = $limits[0]; $page <= $limits[1]; $page++) {
            # Якщо це поточна сторінка, посилання нема і добавляється клас active
            if ($page == $this->current_page) {
                $links .= '<li class="active"><a href="#">' . $page . '</a></li>';
            } else {
                # Інакше генеруємо посилання
                $links .= $this->generateHtml($page);
            }
        }

        # Якщо створилися посилання
        if (!is_null($links)) {
            # Якщо поточна сторінка не перша
            if ($this->current_page > 1)
            # Створюємо посилання "На першу"
                $links = $this->generateHtml(1, '&lt;') . $links;

            # Якщо поточна сторінка не остання
            if ($this->current_page < $this->amount)
            # Створюємо посилання "На останню"
                $links .= $this->generateHtml($this->amount, '&gt;');
        }

        $html .= $links . '</ul>';

        # Повертаємо html
        return $html;
    }

    /**
     * Для генерації HTML-коду посилання
     * @param integer $page - номер сторінки
     * 
     * @return
     */
    private function generateHtml($page, $text = null)
    {
        # Якщо текст посилання не указаний
        if (!$text)
        # Вказуємо, що текст - цифра сторінки
            $text = $page;

        $currentURI = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
        $currentURI = preg_replace('~/page-[0-9]+~', '', $currentURI);
        # Формуємо HTML код посилання і повертаємо
        return
                '<li><a href="' . $currentURI . $this->index . $page . '">' . $text . '</a></li>';
    }

    /**
     *  Для отримки, звідки стартувати
     * 
     * @return масив з початком і кінцем відліку
     */
    private function limits()
    {
        # Вираховуємо посилання зліва (щоб активне посилання було посередині)
        $left = $this->current_page - round($this->max / 2);
        
        # Вирахуваємо початок відліку
        $start = $left > 0 ? $left : 1;

        # Якщо попереду є як мінімум $this->max сторінок
        if ($start + $this->max <= $this->amount) {
        # Визначаємо кінець циклу вперед на $this->max сторінок або просто на мінімум
            $end = $start > 1 ? $start + $this->max : $this->max;
        } else {
            # Кінець - загальна кількість сторінок
            $end = $this->amount;

            # Початок - мінус $this->max з кінця
            $start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
        }

        # Повертаємо
        return
                array($start, $end);
    }

    /**
     * Для установки поточної сторінки
     * 
     * @return
     */
    private function setCurrentPage($currentPage)
    {
        # Отримуємо номер сторінки
        $this->current_page = $currentPage;

        # Якщо поточна сторінка більше нуля
        if ($this->current_page > 0) {
            # Якщо поточна сторінка менше загальної кількості сторінок
            if ($this->current_page > $this->amount)
            # Встановлюємо сторінку на останню
                $this->current_page = $this->amount;
        } else
        # Встановлюємо сторінку на першу
            $this->current_page = 1;
    }

    /**
     * Для отримання загальної кількості сторінок 
     * 
     * @return кількість сторінок
     */
    private function amount()
    {
        # Ділимо і повертаємо
        return ceil($this->total / $this->limit);
    }

}
