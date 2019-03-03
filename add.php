<?php
date_default_timezone_set('Europe/Moscow');

if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    require_once 'config.default.php';
}

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$connect) {
    print('Error: ' . mysqli_connect_error());
    die;
}

mysqli_set_charset($connect, 'utf8');

session_start();

require_once('functions.php');
require_once('mysql_helper.php');

$categories = get_categories($connect);

$errors = [];
$lot    = [];
$user = [];

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'] ?? [];
} else {
    http_response_code(403);
    header('Location: 403.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lot = [
        'name'        => $_POST['name'] ?? null,
        'category'    => $_POST['category'] ?? null,
        'description' => $_POST['description'] ?? null,
        'start_cost'  => $_POST['start_cost'] ?? null,
        'bet_step'    => $_POST['bet_step'] ?? null,
        'final_date'  => $_POST['final_date'] ?? null,
        'image'       => $_FILES['image']['name'] ?? null,
        'image_path'  => $_FILES['image']['tmp_name'] ?? null,
    ];

    $notEmpty = [
        'name',
        'category',
        'description',
        'final_date',
        'start_cost',
        'bet_step',
        'image',
    ];

    foreach ($notEmpty as $field) {
        if (empty($lot[$field])) {
            $errors[$field] = 'Поле не должно быть пустым';
        }
    }

    $numeric = [
        'start_cost',
        'bet_step',
    ];

    foreach ($numeric as $field) {
        if (!empty($lot[$field]) && (int)$lot[$field] <= 0) {
            $errors[$field] = 'Поле должно быть положительным числом';
        }
    }

    if (count($errors) === 0) {

        $url = '/img/'.$lot['image'];
        move_uploaded_file($lot['image_path'], __DIR__.$url);

        $sql = 'INSERT INTO lot (time_of_create, name, category_id, author_id, description,
                                 image, start_cost, bet_step, final_date)
                VALUES (NOW(), ?, ?, 3, ?, ?, ?, ?, ?)';

        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'sissiis',
            $lot['name'],
            $lot['category'],
            $lot['description'],
            $url,
            $lot['start_cost'],
            $lot['bet_step'],
            $lot['final_date']
        );
        mysqli_stmt_execute($stmt);

        $lot_id = mysqli_insert_id($connect);
        header('Location: lot.php?tab='.$lot_id);
    }
}

$page_content = include_template(
    'add.php',
    [
        'categories' => $categories,
        'errors'     => $errors,
        'lot'        => $lot,
    ]
);

$layout_content = include_template(
    'add_layout.php',
    [
        'content'    => $page_content,
        'categories' => $categories,
        'user'       => $user
    ]
);

print($layout_content);
