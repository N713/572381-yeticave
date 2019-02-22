<?php
date_default_timezone_set('Europe/Moscow');
$is_auth = rand(0, 1);
$user_name = 'Илья'; // укажите здесь ваше имя

if(file_exists('config.php')) {
    require_once 'config.php';
} else {
    require_once 'config.default.php';
}

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$connect) {
    print('Error: ' + mysqli_connect_error());
    die;
}

mysqli_set_charset($connect, 'utf8');

require_once('functions.php');
require_once('mysql_helper.php');

$categories = get_categories($connect);

$page_content = include_template('add.php', [
    'categories' => $categories,
]);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = $_POST['name'];
        $category_id = $_POST['category'];
        $description = $_POST['description'];
        $image = $_FILES['image']['name'];
        $start_cost = $_POST['start_cost'];
        $bet_step = $_POST['bet_step'];
        $final_date = $_POST['final_date'];

        $required = ['name', 'category', 'description', 'image',
                     'start_cost', 'bet_step', 'final_date'];

        $vocabulary = [
            'name' => 'Наименование',
            'category' => 'Категория',
            'description' => 'Описание',
            'image' => 'Изображение',
            'start_cost' => 'Начальная цена',
            'bet_step' => 'Шаг ставки',
            'final_date' => 'Дата окончания'
        ];

        foreach ($required as $key => $value) {
            if(empty($_POST[$key])) {
                $errors[$key] = $value;
            }
        };

        if (count($errors)) {
            $page_content = include_template('add.php', [
                'categories' => $categories,
                'errors' => $errors,
                'vocabulary' => $vocabulary,
            ]);
        };

        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/img/'. $image);

        $url = '/img/'. $image;

        $sql = 'INSERT INTO lot (time_of_create, name, category_id, author_id, description,
                                 image, start_cost, bet_step, final_date)
                VALUES (NOW(), ?, ?, 3, ?, ?, ?, ?, ?)';

        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'sissiis', $name, $category_id, $description,
                                $url, $start_cost, $bet_step, $final_date);
        $res = mysqli_stmt_execute($stmt);

        if (count($errors) === 0) {
            if ($res) {
                $lot_id = mysqli_insert_id($connect);
                header("Location: lot.php?tab=" . $lot_id);
            }
        }

        var_dump($errors);
}

$layout_content = include_template('add_layout.php', [
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);
