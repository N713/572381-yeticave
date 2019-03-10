<?php

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
$lot = get_sql_array($connect, $sql, $id);

if (!isset($lot)) {
    header('Location: 404.php');
    exit();
}

$lot = $lot[0];

$current_id = isset($lot['lot_id']) ? $lot['lot_id'] : null;
$lot_name   = isset($lot['lot_name']) ? $lot['lot_name'] : null;
$start_cost = isset($lot['start_cost']) ? $lot['start_cost'] : null;
$final_date = isset($lot['final_date']) ? $lot['final_date'] : null;
$author_id  = isset($lot['author_id']) ? $lot['author_id'] : null;
$bet_step   = isset($lot['bet_step']) ? $lot['bet_step'] : null;

$timer = to_countdown_time($final_date);

$sql = 'SELECT MAX(amount_to_buy) AS max_bet
        FROM bet
        LEFT JOIN lot
        ON lot.id = bet.lot_id
        WHERE lot.id = ? ';

$bet_max = [];
$bet_max = get_sql_array($connect, $sql, $current_id);
$bet_max = $bet_max[0] ?? null;

$current_cost = '';

if (isset($bet_max['max_bet']) && $bet_max['max_bet'] !== null) {
    $current_cost = $bet_max['max_bet'];
} else {
    $current_cost = $start_cost;
}

$bet_min = $current_cost + $bet_step;

$sql = 'SELECT user_id
        FROM bet
        WHERE lot_id = ? ';

$user_bet = [];
$user_bet = get_sql_array($connect, $sql, $current_id);

$not_author  = true;
$none_bet    = true;

foreach ($user_bet as $user_bet) {
    $search = array_search($user['id'], $user_bet, true);

    if ($search) {
        $none_bet = false;
    }
}

if ($author_id === $user['id']) {
    $not_author = false;
}

$errors = [];

$sql = 'SELECT bet_date, amount_to_buy, user_id, user.name AS user_name
        FROM bet
        LEFT JOIN user
        ON bet.user_id = user.id
        WHERE bet.lot_id = ?
        ORDER BY bet_date
        DESC
        LIMIT 10';

$bet_list = [];
$bet_list = get_sql_array($connect, $sql, $current_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $bets = [
        'cost'        => $_POST['cost'] ?? null,
    ];

    $notEmpty = [
        'cost'
    ];

    foreach ($notEmpty as $field) {
        if (empty($bets[$field])) {
            $errors[$field] = 'Поле не должно быть пустым';
        }
    }

    $numeric = [
        'cost'
    ];

    foreach ($numeric as $field) {
        if (!empty($bets[$field]) && (int)$bets[$field] <= 0) {
            $errors[$field] = 'Поле должно быть положительным числом';
        }
    }

    $cost = (int)$bets['cost'];

    if (!is_int($cost)) {
        $errors += ['cost' => 'Введите целое число'];
    }

    if ($cost < $bet_min) {
        $errors += ['cost' => 'Сделайте ставку не ниже минимальной'];
    }

    if (count($errors) === 0) {
        $sql = 'INSERT INTO bet (bet_date, amount_to_buy, user_id, lot_id)
                VALUES (NOW(), ?, ?, ? )';
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'sii',
            $bets['cost'],
            $user['id'],
            $current_id
        );
        mysqli_stmt_execute($stmt);

        echo "<meta http-equiv='refresh' content='0'>";
    }
}

$lot_history = include_template('lot_history.php', [
    'bet_list'       => $bet_list,
]);

$page_content = include_template('lot.php', [
    'lot'            => $lot,
    'user'           => $user,
    'lot_history'    => $lot_history,
    'current_cost'   => $current_cost,
    'bet_min'        => $bet_min,
    'timer'          => $timer,
    'id'             => $id,
    'errors'         => $errors,
    'user_bet'       => $user_bet,
    'not_author'     => $not_author,
    'none_bet'       => $none_bet
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
