<?php

class Board
{
    //Author: 
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
        //Restores a board
        $this -> places = $places;
    }
    //gets array to save as JSON
    public function getPlaces(){
        return $this->places;
    }

    public function isOnBoard($x, $y){
        return $x >= 0 && $x < self::Size && $y >= 0 && $y < self::Size;
    }
    
    public function isEmpty($x, $y){
        return $this ->places[$x][$y] === self::Empty;
    }

    public function stoneAt($x, $y){
        return $this->places[$x][$y];
    }

    public function place($x, $y, $stone){
        $this ->places[$x][$y] = $stone;
    }

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

    public function isFull(){
        return count($this->emptyPlaces())===0;
    }

    public function winningRow($x, $y){
        $stone = $this->places[$x][$y];
        $directions = [[1,0],[0,1],[1,1],[1,-1]];

        foreach ($directions as $d){
            $backward = array_reverse($this->collect($x, $y, -$d[0], -$d[1], $stone));
            $forward = $this->collect($x, $y, $d[0], $d[1], $stone);
            $line = array_merge($backward, [[$x, $y]], $forward);

            if (count($line) >= 5){
                $flat = [];
                foreach (array_slice($line, 0, 5)as $p){
                    $flat[] = $p[0];
                    $flat[] = $p[1];
                }
                return $flat;
            }
        }
        return [];
    }

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