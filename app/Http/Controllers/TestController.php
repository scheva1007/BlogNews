<?php

namespace App\Http\Controllers;

use App\Test\Shape;
use App\Test\ShapeService;
use App\Test\Square;
use App\Test\Triangle;

class TestController extends Controller
{

    public function calculateArea () {
        $square=new Square(5);
        $triangle=new Triangle(2, 5);

        $shapeService=new ShapeService();
        $result=$shapeService->calculateArea($square);
        $result2=$shapeService->calculateArea($triangle);

        return [$result, $result2];
    }
}

