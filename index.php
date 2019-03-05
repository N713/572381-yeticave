<?php
date_default_timezone_set('Europe/Moscow');

if(file_exists('config.php')) {
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

$user = $_SESSION['user'] ?? [];

$sql = 'SELECT id, name FROM category';
$result = mysqli_query($connect, $sql);

if (!$result) {
    print (mysqli_error($connect));
    die;
}

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = 'SELECT lot.id AS lot_id, time_of_create, lot.name AS lot_name, category_id, author_id, description,
            image, start_cost, final_date, bet_step, category.name AS category_name
        FROM lot
        LEFT JOIN category
        ON category.id = lot.category_id';
$result = mysqli_query($connect, $sql);

if (!$result) {
    print (mysqli_error($connect));
    die;
}

$lot_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

require_once('functions.php');

$page_content = include_template('index.php', [
    'lot_list'      => $lot_list,
    'categories'    => $categories,
]);

$layout_content = include_template('layout.php', [
    'content'       => $page_content,
    'page_name'     => 'Главная',
    'categories'    => $categories,
    'user'          => $user
]);

print($layout_content);
