<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salary\CooksSalary;
use App\Salary\DriversSalary;
use App\Salary\SalaryService;

class SalaryController extends Controller
{
    public function calculateSalary () {
        $driver=[
            new DriversSalary(20, 10, 'Alex'),
            new DriversSalary(22, 19, 'Sveta'),
            new DriversSalary(25, 15, 'Jhon'),
            ];
        $cook=[
            new CooksSalary(18, 12, 'Inna'),
            new CooksSalary(29, 14, 'Masha'),
            new CooksSalary(27, 16, 'Bob'),
            ];
        $salaryService=new SalaryService();

        $result=[];

        foreach ($driver as $item) {
            $result['driver'][]=$salaryService->calculateSalary($item);
        }

        foreach ($cook as $item) {
            $result['cook'][]=$salaryService->calculateSalary($item);
        }


        return $result;
    }
}
