<?php
// Hanldes strategy url
// Author:Jose Cruz
// 09-26-2026

require_once __DIR__ . '/../lib/common.php';

if (!isset($_GET['strategy'])) {
    fail('Strategy not specified');
}
$strategy = $_GET['strategy'];
if (!Strategies::exists($strategy)) {
    fail('Unknown strategy');
}

$game = Game::create($strategy);
$game->save();
respond(['response' => true, 'pid' => $game->getPid()]);