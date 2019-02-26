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
        'email'    => $_POST['email'] ?? null,
        'password' => $_POST['password'] ?? null,
        'name'     => $_POST['name'] ?? null,
        'message'  => $_POST['message'] ?? null,
        'image'    => $_POST['image'] ?? null,
    ];

    $not_empty = [
        'email',
        'password',
        'name',
        'message',
    ];

    foreach ($not_empty as $field) {
        if (empty($fields[$field])) {
            $errors[$field] = 'Поле не должно быть пустым';
        }
    }

    if (!empty($fields['email']) and !filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        $errors += ['email' => 'Email некорректен'];
    }

    if (!empty($fields['email']) and filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        if (is_email_available($connect, $fields['email'])) {
            $errors += ['email' => 'Email занят'];
        }
    }

    if (!empty($fields['image'])) {
        $format = is_valid_image($fields['image']);
        if (!$format) {
            $errors += ['image_format' => 'Загрузите изображение в формате jpeg/png'];
        }
    }

    if (count($errors) === 0) {

        $password = password_hash($fields['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO user (registrated_date, email, password, name, contact, avatar)
                VALUES           (NOW(), ?, ?, ?, ?, ?)';
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'sssss',
            $fields['email'],
            $password,
            $fields['name'],
            $fields['message'],
            $fields['image']
        );

        mysqli_stmt_execute($stmt);

        header('Location: index.php');
    }
}

$page_content = include_template(
    'sign_up.php',
    [
        'errors'     => $errors,
        'fields'     => $fields,
    ]
);

$layout_content = include_template(
    'sign_up_layout.php',
    [
        'content'    => $page_content,
        'categories' => $categories,
    ]
);

print($layout_content);

