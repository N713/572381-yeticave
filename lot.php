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

require_once('functions.php');

$categories = get_categories($connect);

if (!isset($_GET['tab'])) {
    print('Error!');
    die;
}

$id = $_GET['tab'];

require_once('mysql_helper.php');

$sql = 'SELECT lot.id AS lot_id, time_of_create, lot.name AS lot_name, category_id, author_id, description,
            image, start_cost, final_date, bet_step, category.name AS category_name
        FROM lot
        LEFT JOIN category
        ON category.id = lot.category_id
        WHERE lot.id = ? ';

$stmt = db_get_prepare_stmt($connect, $sql, [$id]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$lot = mysqli_fetch_all($result, MYSQLI_ASSOC);

$current_id = '';
$lot_name = '';

foreach ($lot as $item) {
    $current_id = $item['lot_id'];
    $lot_name = $item['lot_name'];
}

$page_content = include_template('lot.php', [
    'lot'        => $lot,
]);

$layout_content = include_template('layout.php', [
    'categories' => $categories,
    'content'    => $page_content,
    'lot'        => $lot,
    'user'       => $user,
    'page_name'  => $lot_name
]);

if (!$current_id) {
    http_response_code(404);
    header('Location: 404.php');
    exit();
}

print($layout_content);
