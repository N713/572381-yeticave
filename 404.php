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

$user = $_SESSION['user'] ?? [];

require_once('functions.php');
require_once('mysql_helper.php');

$categories = get_categories($connect);

$page_content = include_template('404.php', [
    'categories'    => $categories,
    'user'          => $user
]);

$layout_content = include_template('layout.php', [
    'content'       => $page_content,
    'categories'    => $categories,
    'user'          => $user,
    'page_name'     => 'Ошибка: 404'
]);

print($layout_content);
