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

$categories = get_categories($connect);

$page_content = include_template('add.php', [
    'categories' => $categories,
]);

$layout_content = include_template('add_layout.php', [
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);
