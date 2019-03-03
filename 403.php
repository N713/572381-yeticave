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

$user = [];
$categories = get_categories($connect);

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'] ?? [];
}

$page_content = include_template('403.php', [
    'categories'    => $categories,
    'user'          => $user
]);

$layout_content = include_template('403_layout.php', [
    'content'       => $page_content,
    'categories'    => $categories,
    'user'          => $user
]);

print($layout_content);
