<?php
    /**
     * Функция для форматирования цены, а именно отделения разряда тысяч
     * Пример: 14000 -> 14 000
     *
     * @param int $price
     *
     * @return string
     */
    function format_price ($price) {
        $ceiled_price = ceil($price);
        if ($ceiled_price > 1000) {
            $ceiled_price = number_format($ceiled_price, 0, ',', ' ');
        }

        return $ceiled_price . ' ₽';
    }

    /**
     * Функция - шаблонизатор
     *
     * $name - имя файла - шаблона
     * $data - данные в виде ассоциативного массива
     *
     * @param string $name
     *
     * @param array $data
     */
    function include_template($name, $data) {
        $name = 'templates/' . $name;
        $result = '';

        if (!is_readable($name)) {
            return $result;
        }

        ob_start();
        extract($data);
        require $name;

        $result = ob_get_clean();

        return $result;
    }

    /**
     * Функция для отсчета времени
     *
     * @param $time - финальная дата
     *
     * @return string $time - оставшееся время
     */
    function to_countdown_time($time) {
        $time_difference = strtotime($time) - time();
        $hours = floor( $time_difference / 3600 );
        $minutes = floor( ($time_difference % 3600) / 60 );
        $time = $hours . ':' .  $minutes;
        if($minutes < 10) {
            $time = $hours . ':' . '0' . $minutes;
        }

        return $time;
    }

    /**
     * Функция для получения категорий лотов
     *
     * @param $connect - ресурс подключения
     *
     * @return array
     */
    function get_categories($connect) {
        $sql = 'SELECT id, name FROM category';
        $result = mysqli_query($connect, $sql);

        if (!$result) {
            print (mysqli_error($connect));
            die;
        }

        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $categories;
    }

    /**
     * Функция проверки email на занятость
     *
     * @param $link - ресурс подключения
     *
     * @param $email - почта
     *
     * @return boolean
    */
    function is_email_available ($link, $email) {
        $email = mysqli_real_escape_string($link, $email);
        $sql = "SELECT id FROM user WHERE email = '$email'";
        $res = mysqli_query($link, $sql);
        $is_available = false;

        if (mysqli_num_rows($res) > 0) {
            $is_available = true;
        }

        return $is_available;
    }

    /**
     * Проверяет изображение на разрешенные форматы
     *
     * @param $image - изображение
     *
     * @return boolean
    */
    function is_valid_image ($image) {

        if (
            mime_content_type($image) === 'image/png' or
            mime_content_type($image) === 'image/jpeg'
        ) {

            return true;
        }

        return false;
    }

    /**
     * Получает массив из запроса
     * Использует подготовленное выражение
     *
     * @param $link - ресурс соединиения
     *
     * @param $sql  - sql запрос
     *
     * @param $name - имя будущего массива
     *
     * @param $variable - переменная для вставки в выражение
     *
     * @return array $name
    */
    function get_sql_array ($link, $sql, $name, $variable) {

        $stmt = db_get_prepare_stmt($link, $sql, [$variable]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $name = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $name;
    }
