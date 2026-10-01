<?php
// Omok web service - shared setup and JSON response helpers
// Author: Your Name

require_once __DIR__ . '/Board.php';
require_once __DIR__ . '/MoveStrategy.php';
require_once __DIR__ . '/RandomStrategy.php';
require_once __DIR__ . '/SmartStrategy.php';
require_once __DIR__ . '/Strategies.php';
require_once __DIR__ . '/Game.php';

// Sends data as JSON and stops the script.
function respond($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Sends an error response and stops the script.
function fail($reason)
{
    respond(['response' => false, 'reason' => $reason]);
}