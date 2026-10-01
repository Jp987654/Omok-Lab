<?php
// Omok web service - GET /info
// Author: Your Name

require_once __DIR__ . '/../lib/common.php';

respond([
    'size' => Board::Size,
    'strategies' => Strategies::names(),
]);