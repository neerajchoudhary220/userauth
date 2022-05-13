<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Validation\Rule;


class EmployeeController extends Controller
{

    //create new employee
    public function addemployee(Request $request)
    {

        $request->validate([
            'firstname' => 'required |string |max:16 |min:3|regex:/^[a-z ,."-]+$/i',
            'mniddleame' => 'string |min:3|max:8|regex:/^[a-z ,."-]+$/i',
            'lastname' => 'required|string|min:3|max:16|regex:/^[a-z ,."-]+$/i',
            'email' => 'required|string|unique:employees,email|regex:/(.+)@(.+)\.(.+)/i',
            'mobile' => 'unique:employees,mobile|numeric|digits:10',
            'dob' => 'date_format:Y-m-d|before: -10 years',
            'gender' => 'string',
            'status' => 'string|min:5|max:8'
        ]);

        $employee_id = 0;
        if (Employee::exists()) {
            $employee_id = Employee::latest('id')->first()->Employee_id + 1; // the most recent record

        }

        // dd($employee_id);

        $employee = Employee::create([
            'first_name' => $request->firstname,
            'middle_name' => $request->middlename,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->dob,
            'gender' => $request->gender ?? 'male',
            'Employee_id' => $employee_id,

        ]);

        // dd($employee);
        return responsedata(msg: 'New Employee added successfully !', data: [
            'Employee' => $employee,

        ]);
    }


    //update employee
    public function update(Request $request)
    {



        $employee = Employee::where('email', $request->email)->first();
        // dd($employee);


        if ($employee) {
            $request->validate([
                'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
                'mobile' => 'unique:employees,mobile|numeric|digits:10',
                'firstname' => 'string |max:16 |min:3|regex:/^[a-z ,."-]+$/i',
                'middlename' => 'string |min:3|max:8|regex:/^[a-z ,."-]+$/i',
                'lastname' => 'string|min:3|max:16|regex:/^[a-z ,."-]+$/i',
                'dob' => 'date_format:Y-m-d|before: -10 years',
                'gender' => 'string|min:4|max:6|regex:/^[a-z ,."-]+$/i',
                'status' => 'string|min:5|max:8'
            ]);


            $employee->update([
                'first_name' => $request->firstname ?? $employee->first_name,
                'middle_name' => $request->middlename ?? $employee->middle_name,
                'last_name' => $request->lastname ?? $employee->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile ?? $employee->mobile,
                'date_of_birth' => $request->dob ?? $employee->date_of_birth,
                'gender' => $request->gender ?? $employee->gender,

            ]);

            $emp =  Employee::where('email', $request->email)->first();
            return responsedata(msg: 'Updated successfully !', data: ['employee' => $emp]);
        } else {
            return responsedata(msg: 'Email is not found !', status: 402);
        }
    }

    //delete employee
    public function deleteEmployee(Request $request)
    {

        $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        ]);

        $employee = Employee::where('email', $request->email)->delete();
        if ($employee) {;
            return responsedata(
                msg: 'Successfully deleted employee !',

            );
        } else {
            return responsedata(
                msg: 'Eamil is not found !',
                status: 402
            );
        }

        // dd($employee);
    }

    //view employee list

    public function viewEmployeeList()
    {
        $paginate = Employee::paginate(2);
        // dd($paginate);
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
