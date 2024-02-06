<?php

namespace App\Salary;

class DriversSalary implements Salary {
    private $hours;
    private $money;
    private $name;

    public function __construct ($hours, $money, $name) {
        $this->hours=$hours;
        $this->money=$money;
        $this->name=$name;
    }

    public function calculateSalary()
    {
        return $this->money*$this->hours;
    }

    public function getName()
    {
        return $this->name;
    }

}
