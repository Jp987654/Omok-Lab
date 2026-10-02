<?php
// Get info
// Author: Jose Cruz
// 09-26-2026

require_once __DIR__ . '/../lib/common.php';

respond([
    'size' => Board::Size,
    'strategies' => Strategies::names(),
]);