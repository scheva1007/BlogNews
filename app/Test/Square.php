<?php

namespace App\Test;

class Square implements Shape
{
    private $side;

    public function __construct($side)
    {
        $this->side = $side;
    }

    public function calculateArea()
    {
        return $this->side * $this->side;
    }

    public function getName()
    {
         return 'Square';
    }
}


