<?php
// Interface for random move, simplest 
// Author: Ian Bautista
// 09-28-2026

class RandomStrategy implements MoveStrategy
{
    public function pickMove(Board $board)
    {
        $empty = $board->emptyPlaces();
        return $empty[array_rand($empty)];
    }
}