<?php
// Omok web service - smart strategy
// Tries, in order: make 5, block 5, make 4, block 4, make 3, block 3, make 2, block 2.
// Author: Your Name

class SmartStrategy extends RandomStrategy
{
    public function pickMove(Board $board)
    {
        for ($length = 5; $length >= 2; $length--) {
            foreach ([Board::Computer, Board::Player] as $stone) {
                foreach ($board->emptyPlaces() as $place) {
                    if ($this->longestLine($board, $place[0], $place[1], $stone) >= $length) {
                        return $place;
                    }
                }
            }
        }
        return parent::pickMove($board); // nothing useful found: play randomly
    }

    // Longest line $stone would have if it were placed at (x, y).
    private function longestLine(Board $board, $x, $y, $stone)
    {
        $longest = 0;
        foreach ([[1, 0], [0, 1], [1, 1], [1, -1]] as $d) {
            $length = 1
                + count($board->collect($x, $y, $d[0], $d[1], $stone))
                + count($board->collect($x, $y, -$d[0], -$d[1], $stone));
            $longest = max($longest, $length);
        }
        return $longest;
    }
}