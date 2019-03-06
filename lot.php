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

require_once('mysql_helper.php');
require_once('functions.php');

$categories = get_categories($connect);

if (!isset($_GET['tab'])) {
    print('Error!');
    die;
}

$id = $_GET['tab'];

$sql = 'SELECT lot.id AS lot_id, time_of_create, lot.name AS lot_name, category_id, author_id, description,
            image, start_cost, final_date, bet_step, category.name AS category_name
        FROM lot
        LEFT JOIN category
        ON category.id = lot.category_id
        WHERE lot.id = ? ';

$lot = [];
$lot = get_sql_array($connect, $sql, $lot, $id);

$current_id = '';
$lot_name   = '';
$start_cost = '';
$final_date = '';

foreach ($lot as $item) {
    $current_id = $item['lot_id'];
    $lot_name   = $item['lot_name'];
    $start_cost = $item['start_cost'];
    $final_date = $item['final_date'];
}

$timer = to_countdown_time($final_date);

$sql = 'SELECT MAX(amount_to_buy) AS max_bet
        FROM bet
        LEFT JOIN lot
        ON lot.id = bet.lot_id
        WHERE lot.id = ? ';

$bet_max = [];
$bet_max = get_sql_array($connect, $sql, $bet_max, $current_id);
$bet_max = $bet_max[0] ?? null;

$sql = 'SELECT bet_step
        FROM lot
        WHERE id = ? ';

$bet_step = [];
$bet_step = get_sql_array($connect, $sql, $bet_step, $current_id);
$bet_step = $bet_step[0] ?? null;

$current_cost = '';

if ($bet_max['max_bet'] !== null) {
    $current_cost = $bet_max['max_bet'];
} else {
    $current_cost = $start_cost;
}

$bet_min = $current_cost + $bet_step['bet_step'];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bets = [
        'bet_amount' => $_POST['cost'] ?? null,
    ];

    $not_empty = [
        'bet_amount'
    ];

    foreach ($not_empty as $field) {
        if (empty($bets[$field])) {
            $errors[$field] = 'Поле не должно быть пустым';
        }
    }

    $numeric = [
        'bet_amount'
    ];

    foreach ($numeric as $field) {
        if (!empty($bets[$field]) && (int)$bets[$field] <= 0) {
            $errors[$field] = 'Поле должно быть положительным числом';
        }
    }
}

$lot_bet = include_template('lot_bet.php', [
    'user'           => $user,
    'current_cost'   => $current_cost,
    'bet_min'        => $bet_min,
    'timer'          => $timer
]);

$lot_history = include_template('lot_history.php', [

]);

$page_content = include_template('lot.php', [
    'lot'            => $lot,
    'user'           => $user,
    'lot_bet'        => $lot_bet,
    'lot_history'    => $lot_history,
]);

$layout_content = include_template('layout.php', [
    'categories'     => $categories,
    'content'        => $page_content,
    'lot'            => $lot,
    'user'           => $user,
    'page_name'      => $lot_name
]);

if (!$current_id) {
    http_response_code(404);
    header('Location: 404.php');
    exit();
}

print($layout_content);
