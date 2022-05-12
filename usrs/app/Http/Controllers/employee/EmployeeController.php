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
            'firstname' => 'required |string |max:16 |min:3',
            'middlename' => 'string |min:3|max:8',
            'lastname' => 'required|string|min:3|max:16',
            'email' => 'required|string|unique:employees,email|regex:/(.+)@(.+)\.(.+)/i',
            'mobile' => 'unique:employees,mobile|numeric|digits:10',
            'dob' => 'date_format:Y-m-d|before: -10 years',
            'gender' => 'string|min:4|max:6',
            'status' => 'string|min:5|max:8'
        ]);

        $employee_id = 0;
        if (Employee::exists()) {
            $employee_id = Employee::latest('id')->first()->Employee_id + 1; // the most recent record

        }



        $employee = Employee::create([
            'first_name' => $request->firstname,
            'middle_name' => $request->middlename,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->dob,
            'gender' => $request->gender,
            'employee_id' => $employee_id,

        ]);

        // dd($employee);
        return responsedata(msg: 'New Employee added successfully !', data: [
            'Employee' => $employee,

        ]);
    }


    //update employee
    public function update(Request $request)
    {

        $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'mobile' => 'numeric|digits:10',
            'firstname' => 'string |max:16 |min:3',
            'middlename' => 'string |min:3|max:8',
            'lastname' => 'string|min:3|max:16',
            'dob' => 'date_format:Y-m-d|before: -10 years',
            'gender' => 'string|min:4|max:6',
            'status' => 'string|min:5|max:8'
        ]);

        $employee = Employee::where('email', $request->email)->first();
        // dd($employee);
        $employee->update([
            'first_name' => $request->firstname,
            'middle_name' => $request->middlename,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->dob,
            'gender' => $request->gender,

        ]);
        $emp =  Employee::where('email', $request->email)->first();
        return responsedata(msg: 'Updated successfully !', data: ['employee' => $emp]);
    }

    //delete employee

}
