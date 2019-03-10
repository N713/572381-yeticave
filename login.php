<?php

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
$password = '';

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

    if (!empty($fields['email']) and filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT id, registrated_date, email, name,
                        password, avatar, contact
                FROM user
                WHERE email = ? ";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            's',
            $fields['email']
        );
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    $user = $user[0] ?? null;

    if (!$user and !count($errors)) {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if ($user and !count($errors)) {
        $password = password_verify($fields['password'], $user['password']);
    }

    if (!$user and !$password) {
        $errors['password'] = 'Вы ввели неверный пароль';
    }

    if ($user and !count($errors) and !$password) {
        $errors['password'] = 'Вы ввели неверный пароль';
    }

    if ($user and !count($errors) and $password) {
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit();
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
    'layout.php',
    [
        'content'    => $page_content,
        'categories' => $categories,
        'user'       => $user,
        'page_name'  => 'Вход'
    ]
);

print($layout_content);
