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
$fields = [];
$user   = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fields = [
        'email'       => $_POST['email'] ?? null,
        'password'    => $_POST['password'] ?? null,
        'name'        => $_POST['name'] ?? null,
        'message'     => $_POST['message'] ?? null,
        'image'       => $_FILES['image']['name'] ?? null,
        'image_path'  => $_FILES['image']['tmp_name'] ?? null,
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

    if (isset($_FILES['image']['error']) && $_FILES['image']['error'] === 1) {
        $errors += ['image_format' => 'Произошла ошибка при загрузке'];
    } else if (!empty($fields['image'])) {
        $format = is_valid_image($fields['image_path']);
        if ($format === false) {
            $errors += ['image_format' => 'Загрузите изображение в формате jpeg/png'];
        }
    }

    if (count($errors) === 0) {

        if ($fields['image']) {
            $url = '/img/' . $fields['image'];
            move_uploaded_file($fields['image_path'], __DIR__ . $url);
        }

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
            $url
        );

        mysqli_stmt_execute($stmt);

        header('Location: login.php');
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
        'user'       => $user
    ]
);

print($layout_content);
