<?php
// Omok web service - picks a random empty place
// Author: Your Name

class RandomStrategy implements MoveStrategy
{
    public function pickMove(Board $board)
    {
        $empty = $board->emptyPlaces();
        return $empty[array_rand($empty)];
    }
}