<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeCrud extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "Hello";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return "update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "delete";
    }

    public function search(Request $request, $id)
    {
        return "search";
    }
}
