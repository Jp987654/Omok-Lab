<?php
require_once 'lib/Board.php';

$board = new Board();
for ($x = 3; $x <= 7; $x++) {
    $board->place($x, 5, Board::Player);
}
echo json_encode($board->winningRow(7, 5)) . "\n";   // should print a row
echo json_encode($board->winningRow(3, 5)) . "\n";   // same row, found from the other end
echo count($board->emptyPlaces()) . "\n";            // 225 - 5 = 220