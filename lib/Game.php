<?php
// Omok web service - a game in progress, persisted as a JSON file
// Author: Jose Cruz

class Game
{
    // Folder where each game's JSON file gets saved.
    const DATA_DIR = __DIR__ . '/../data';

    private $pid;
    private $strategyName;
    private $board;

    // Private so games only get made through create() or load().
    private function __construct($pid, $strategyName, Board $board)
    {
        $this->pid = $pid;
        $this->strategyName = $strategyName;
        $this->board = $board;
    }

    // Starts a brand-new game with an empty board
    public static function create($strategyName)
    {
        return new Game(uniqid(), $strategyName, new Board());
    }

    // Restores a saved game, or returns null if the pid is unknown.
    public static function load($pid)
    {
        // uniqid() only produces hex characters; rejecting anything else
        // also stops tricks like pid=../../somefile
        if (!preg_match('/^[0-9a-f]+$/', $pid)) {
            return null;
        }
        $file = self::fileFor($pid);
        if (!file_exists($file)) {
            return null;
        }
        $data = json_decode(file_get_contents($file), true);
        return new Game($pid, $data['strategy'], new Board($data['board']));
    }

    // Writes the strategy and board to data/<pid>.json, making the folder if needed.
    public function save()
    {
        if (!is_dir(self::DATA_DIR)) {
            mkdir(self::DATA_DIR);
        }
        $data = [
            'strategy' => $this->strategyName,
            'board' => $this->board->getPlaces(),
        ];
        file_put_contents(self::fileFor($this->pid), json_encode($data));
    }

    public function getPid()
    {
        return $this->pid;
    }

    public function getBoard()
    {
        return $this->board;
    }

    // Builds a fresh strategy object from the saved name
    public function getStrategy()
    {
        return Strategies::create($this->strategyName);
    }

    // Path of the JSON file for a given pid
    private static function fileFor($pid)
    {
        return self::DATA_DIR . '/' . $pid . '.json';
    }

    // Places a stone and reports back whether that move won or ended in a draw
    public function makeMove($x, $y, $stone)
    {
        $this->board->place($x, $y, $stone);
        $row = $this->board->winningRow($x, $y);
        $isWin = count($row) > 0;

        return [
            'x' => $x,
            'y' => $y,
            'isWin' => $isWin,
            'isDraw' => !$isWin && $this->board->isFull(),
            'row' => $row,
        ];
    }
}