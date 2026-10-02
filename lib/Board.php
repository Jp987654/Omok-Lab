<?php

class Board
{
    //Author: Jose Cruz
    // 09-26-2026

    // Constant variables
    const Size = 15;
    const Empty = 0;
    const Player = 1;
    const Computer = 2;

    //Actual board filled with 15 by 15
    private $places;

    //Creates an empty board
    public function __construct($places = null){
        if ($places === null) {
            $column = array_fill(0, self::Size, self::Empty);
            $places = array_fill(0,self::Size, $column);
        }
        $this -> places = $places;
    }

    //gets array to save as JSON
    public function getPlaces(){
        return $this->places;
    }

    //Checks that x and y are both inside the 15 by 15 board
    public function isOnBoard($x, $y){
        return $x >= 0 && $x < self::Size && $y >= 0 && $y < self::Size;
    }

    //True if nobody has played at x,y
    public function isEmpty($x, $y){
        return $this ->places[$x][$y] === self::Empty;
    }

    //Gets whatever stone is at x,y
    public function stoneAt($x, $y){
        return $this->places[$x][$y];
    }

    //Puts a stone down at x,y
    public function place($x, $y, $stone){
        $this ->places[$x][$y] = $stone;
    }

    //Goes through the whole board and returns every empty spot as result array
    public function emptyPlaces(){
        $result = [];
        for ($x = 0; $x < self::Size; $x++){
            for ($y = 0; $y < self::Size; $y++){
                if ($this ->isEmpty($x,$y)){
                    $result[] = [$x, $y];
                }
            }
        }
        return $result;
    }

    //Board is full when there are no empty spots left, method to decide draw
    public function isFull(){
        return count($this->emptyPlaces())===0;
    }

    //Checks if the stone at x,y made 5 in a row
    //Returns the 5 places as [x1, y1, x2, y2, ...] or an empty array if no win
    public function winningRow($x, $y){
        $stone = $this->places[$x][$y];

        //Directions to check: horizontal, vertical, diagonal, other diagonal
        $dxs = [1, 0, 1, 1];
        $dys = [0, 1, 1, -1];

        for ($i = 0; $i < 4; $i++){
            $dx = $dxs[$i];
            $dy = $dys[$i];

            //Walk backwards until the line ends to find where it starts
            $startX = $x;
            $startY = $y;
            while ($this->isOnBoard($startX - $dx, $startY - $dy) && $this->places[$startX - $dx][$startY - $dy] === $stone){
                $startX = $startX - $dx;
                $startY = $startY - $dy;
            }

            //Now count forward from the start to get the full length
            $length = 0;
            $cx = $startX;
            $cy = $startY;
            while ($this->isOnBoard($cx, $cy) && $this->places[$cx][$cy] === $stone){
                $length++;
                $cx = $cx + $dx;
                $cy = $cy + $dy;
            }

            //Found a win, so save the first 5 places of the line
            if ($length >= 5){
                $row = [];
                $cx = $startX;
                $cy = $startY;
                for ($k = 0; $k < 5; $k++){
                    $row[2 * $k] = $cx;
                    $row[2 * $k + 1] = $cy;
                    $cx = $cx + $dx;
                    $cy = $cy + $dy;
                }
                return $row;
            }
        }
        //No direction had 5 in a row
        return [];
    }

    //Starts next to (x, y) and keeps stepping by (dx, dy) while the stones match
    //Returns the matching places, doesn't include (x, y) itself
     public function collect($x, $y, $dx, $dy, $stone)
    {
        $cells = [];
        $cx = $x + $dx;
        $cy = $y + $dy;
        while ($this->isOnBoard($cx, $cy) && $this->places[$cx][$cy] === $stone) {
            $cells[] = [$cx, $cy];
            $cx += $dx;
            $cy += $dy;
        }
        return $cells;
    }
}
