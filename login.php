<?php
date_default_timezone_set('Europe/Moscow');
$is_auth   = rand(0, 1);
$user_name = 'Илья'; // укажите здесь ваше имя

if (file_exists('config.php')) {
    require_once 'config.php';
} else {
    require_once 'config.default.php';
}

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$connect) {
    print('Error: '.mysqli_connect_error());
    die;
}

mysqli_set_charset($connect, 'utf8');

require_once('functions.php');
require_once('mysql_helper.php');

$categories = get_categories($connect);

$errors = [];
$fields = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fields = [
        'email'       => $_POST['email'] ?? null,
        'password'    => $_POST['password'] ?? null,
    ];

    $not_empty = [
        'email',
        'password',
    ];

    foreach ($not_empty as $field) {
        if (empty($fields[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if (!empty($fields['email']) and !filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        $errors += ['email' => 'Email некорректен'];
    }
}

$page_content = include_template(
    'login.php',
    [
        'errors'     => $errors,
        'fields'     => $fields,
    ]
);

$layout_content = include_template(
    'login_layout.php',
    [
        'content'    => $page_content,
        'categories' => $categories,
    ]
);

print($layout_content);
