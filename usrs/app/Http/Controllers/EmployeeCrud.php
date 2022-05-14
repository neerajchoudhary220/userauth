<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use App\Models\Employee;
use PhpParser\Node\Expr\Empty_;

class EmployeeCrud extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = Employee::paginate(5);
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


        // dd($employee_id);
        $employee_id = Employee::employeeID();

        $employee = Employee::create([
            'first_name' => $request->firstname,
            'middle_name' => $request->middlename,
            'last_name' => $request->lastname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'date_of_birth' => $request->dob,
            'gender' => $request->gender ?? 'male',
            'status' => $request->status ?? 'active',
            'Employee_id' => $employee_id,

        ]);

        // dd($employee);
        return responsedata(msg: 'New Employee added successfully !', data: [
            'employee' => $employee,

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

        $employee = Employee::find($id);
        if ($employee) {
            return responsedata(data: [
                'employee' => $employee
            ]);
        } else {
            return responsedata(msg: 'This employee is not exist !', status: 402);
        }

        // return new EmployeeResource($employee);
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

        $employee = Employee::find($id);


        // dd($employee);


        if ($employee) {
            $request->validate([
                // 'mobile' => 'unique:employees,mobile|numeric|digits:10',
                'firstname' => 'string |max:16 |min:3|regex:/^[a-z ,."-]+$/i',
                'middlename' => 'string |min:3|max:8|regex:/^[a-z ,."-]+$/i',
                'lastname' => 'string|min:3|max:16|regex:/^[a-z ,."-]+$/i',
                'dob' => 'date_format:Y-m-d|before: -10 years',
                'gender' => 'string|min:4|max:6|regex:/^[a-z ,."-]+$/i',
                'status' => 'string',

            ]);

            $employee->update([
                'first_name' => $request->firstname ?? $employee->first_name,
                'middle_name' => $request->middlename ?? $employee->middle_name,
                'last_name' => $request->lastname ?? $employee->last_name,
                // 'mobile' => $request->mobile ?? $employee->mobile,
                'date_of_birth' => $request->dob ?? $employee->date_of_birth,
                'gender' => $request->gender ?? $employee->gender,
                'status' => $request->status ?? $employee->status

            ]);

            $emp =  Employee::find($id);
            return responsedata(msg: 'Updated successfully !', data: ['employee' => $emp]);
        } else {
            return responsedata(msg: 'This employee is not exist !', status: 402);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->delete();
            return responsedata(msg: 'Deleted successfully !');
        } else {
            return responsedata(msg: 'This employee is not exist !', status: 402);
        }
    }

    public function search(Request $request, $id)
    {
        return "search";
    }

    public function statusFilter(Request $request, $status)
    {
        // $employee = Employee::paginate(5);
        $employee = Employee::where('status', $status)->paginate(5);
        if ($employee) {
            $pag = Employee::pagination($employee);
            return $pag;
            // return responsedata(msg: 'All ' . $status . ' employee', data: ['employee' => $employee]);
        }
    }

    public function GenderFilter($gender)
    {
        $employee = Employee::where('gender', $gender)->paginate(5);
        return Employee::pagination($employee);
    }
}
