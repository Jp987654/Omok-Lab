<?php
// Omok web service - registry of available strategies
// Author: Your Name

class Strategies
{
    const CLASSES = [
        'Smart' => 'SmartStrategy',
        'Random' => 'RandomStrategy',
    ];

    public static function names()
    {
        return array_keys(self::CLASSES);
    }

    public static function exists($name)
    {
        return isset(self::CLASSES[$name]);
    }

    public static function create($name)
    {
        $class = self::CLASSES[$name];
        return new $class();
    }
}