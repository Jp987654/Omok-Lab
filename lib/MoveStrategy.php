<?php
// Omok web service - interface for computer move strategies
// Author: Your Name

interface MoveStrategy
{
    // Returns the computer's chosen move as [x, y].
    public function pickMove(Board $board);
}