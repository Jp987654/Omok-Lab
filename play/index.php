<?php
// pass parameters through url
// Author: Jose Cruz
// 09-26-2026

require_once __DIR__ . '/../lib/common.php';

// Reads a board coordinate from the query string, or fails with an error.
function readCoordinate($name)
{
    if (!isset($_GET[$name])) {
        fail("$name not specified");
    }
    $value = $_GET[$name];
    if (!ctype_digit($value) || (int) $value >= Board::Size) {
        fail("Invalid $name coordinate, $value");
    }
    return (int) $value;
}

if (!isset($_GET['pid'])) {
    fail('Pid not specified');
}
$game = Game::load($_GET['pid']);
if ($game === null) {
    fail('Unknown pid');
}

$x = readCoordinate('x');
$y = readCoordinate('y');
$board = $game->getBoard();
if (!$board->isEmpty($x, $y)) {
    fail("Place not empty, ($x, $y)");
}

// Player's move
$playerMove = $game->makeMove($x, $y, Board::Player);
$response = ['response' => true, 'ack_move' => $playerMove];

// Computer's reply, only if the game isn't over
if (!$playerMove['isWin'] && !$playerMove['isDraw']) {
    [$cx, $cy] = $game->getStrategy()->pickMove($board);
    $response['move'] = $game->makeMove($cx, $cy, Board::Computer);
}

$game->save();
respond($response);