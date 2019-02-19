<?php
    /**
     *Функция для форматирования цены, а именно отделения разряда тысяч
     *Пример: 14000 -> 14 000
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
     *Функция - шаблонизатор
     *
     *$name - имя файла - шаблона
     *$data - данные в виде ассоциативного массива
     *
     *@param string $name
     *
     *@param array $data
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
     * @return string
     */
    function to_countdown_time() {
        $time_difference = strtotime('tomorrow') - time();
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
     *@param $connect - ресурс подключения
     *
     *@return array
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
