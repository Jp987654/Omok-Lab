<?php
// Internface for move strategies, just calls strat
// Author: Jose Cruz 09-26-2026


interface MoveStrategy
{
    // Returns the computer's chosen move as [x, y].
    public function pickMove(Board $board);
}