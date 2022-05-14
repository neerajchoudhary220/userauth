<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected  $fillable = [
        'first_name', 'last_name', 'middle_name', 'Employee_id', 'email', 'mobile', 'date_of_birth', 'gender', 'status'
    ];

    //Generate employee id
    public static function employeeID()
    {
        $employee_id = "PZ" . substr(date('Y'), (strlen(date('Y')) - 2));
        $employee_id = str_pad($employee_id, 8, 0);
        if (Employee::exists()) {

            $employee_id = Employee::latest('id')->first()->Employee_id; //
            $employee_id = (int)filter_var($employee_id, FILTER_SANITIZE_NUMBER_INT);

            $employee_id =  "PZ" . ($employee_id + 1);
        }
        return $employee_id;
    }

    //pagination realted data
    public static function pagination($paginate)
    {
        $page = [
            'current-page' => $paginate->currentPage(),
            "per-page" => $paginate->perPage(),
            "from" => $paginate->firstItem(),
            "to" => $paginate->lastItem(),
            "total" => $paginate->total(),
            "last-page" => $paginate->lastPage()
        ];

        $links = [
            'first' => $paginate->url(1),
            'prev' => $paginate->previousPageUrl(),
            'next' => $paginate->nextPageUrl(),
            'last' => $paginate->url($paginate->lastPage()),
        ];

        return responsedata(msg: 'Employee ', data: [
            'employee' => $paginate->items(),
            'page' => $page,
            'links' => $links,

        ]);
    }
}
