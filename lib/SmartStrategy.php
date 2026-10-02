<?php
// Tries to find a row of 5 then 4 then 3 then 2
// Author: Ian Bautista
// 09-29-2026

class SmartStrategy extends RandomStrategy
{
    //
    public function pickMove(Board $board)
    {
        // nested loop trying to find a long streak to follow
        for ($length = 5; $length >= 2; $length--) { // set parameters for loop
            foreach ([Board::Computer, Board::Player] as $stone) {
                foreach ($board->emptyPlaces() as $place) { // check empty places
                    if ($this->longestLine($board, $place[0], $place[1], $stone) >= $length) {
                        return $place;
                    }
                }
            }
        }
        return parent::pickMove($board); // if no good strategy was found then place random piece
    }

    // returns the longst line $stone would have if it were placed at x,y
    private function longestLine(Board $board, $x, $y, $stone)
    {
        $longest = 0;
        foreach ([[1, 0], [0, 1], [1, 1], [1, -1]] as $d) {
            $length = 1 + count($board->collect($x, $y, $d[0], $d[1], $stone)) + count($board->collect($x, $y, -$d[0], -$d[1], $stone));
            $longest = max($longest, $length);
        }
        return $longest;
    }
}