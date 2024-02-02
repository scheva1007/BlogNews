<?php

namespace App\Test;

class Triangle implements Shape
{
    private $base;
    private $height;

    public function __construct($base, $height)
    {
        $this->base = $base;
        $this->height = $height;
    }

    public function calculateArea()
    {
        return 0.5 * $this->base * $this->height;
    }

    public function getName()
    {
        return 'Triangle';
    }
}
