<?php
// hanldes all the strategies, can support more strategies
// Author: Ian Bautista 09-28-2026

class Strategies
{
    // Maps each strategy name the client sees to its class.
    const CLASSES = [
        'Smart' => 'SmartStrategy',
        'Random' => 'RandomStrategy',
    ];

    // All strategy names, used by /info.
    public static function names()
    {
        return array_keys(self::CLASSES);
    }

    // True if the name is one of the strategies above.
    public static function exists($name)
    {
        return isset(self::CLASSES[$name]);
    }

    // Makes a new strategy object from its name.
    public static function create($name)
    {
        $class = self::CLASSES[$name];
        return new $class();
    }
}