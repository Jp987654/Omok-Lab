<?php
// Resnonse json handler
// Author: Ian Bautista 09-28-2026

require_once __DIR__ . '/Board.php';
require_once __DIR__ . '/MoveStrategy.php';
require_once __DIR__ . '/RandomStrategy.php';
require_once __DIR__ . '/SmartStrategy.php';
require_once __DIR__ . '/Strategies.php';
require_once __DIR__ . '/Game.php';

// send data as JSON and end
function respond($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// sends error and reason, error handling
function fail($reason)
{
    respond(['response' => false, 'reason' => $reason]);
}