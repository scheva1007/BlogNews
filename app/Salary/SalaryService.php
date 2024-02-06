<?php

namespace App\Salary;

class SalaryService
{
    public function calculateSalary(Salary $salary)
    {
         $salaryWorker=$salary->calculateSalary();
         $nameWorker=$salary->getName();
         return $nameWorker . '-' . $salaryWorker.' grn';
    }
}
