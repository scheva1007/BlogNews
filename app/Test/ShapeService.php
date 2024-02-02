<?php

namespace App\Test;


class ShapeService {
    public function calculateArea (Shape $shape) {

        $shapeArea=$shape->calculateArea();
        $shapeName=$shape->getName();

        return 'Area for ' . $shapeName . ' equals:' . $shapeArea;
    }
}
