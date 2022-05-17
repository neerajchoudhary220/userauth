<?php

namespace App\Http\Controllers;

use App\Http\Resources\Employee\EmployeeCollection;
use App\Http\Resources\Employee\EmployeeResource;
use Illuminate\Http\Request;
use App\Models\Employee;
use PhpParser\Node\Expr\Empty_;
use Carbon\Carbon;

class EmployeeCrud extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $request->validate([
            'gender' => 'string',
            'status' => 'string',
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d'
        ]);

        $query = Employee::query();



        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->start_date && $request->end_date) {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date);

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if ($request->search) {

            $q = $request->search;
            //     $query->andwhere([
            //        where->('first_name', 'like', '%' . $q . '%')->orWhere('last_name', 'like', '%' . $q . '%')->orWhere('mobile', 'like', '%' . $q . '%')->orWhere('Employee_id', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%')->orWhere('gender', 'like', '%' . $q . '%')->orWhere('status', 'like', '%' . $q . '%')->orWhere('date_of_birth', 'like', '%' . $q . '%')
            //     ]);
            // }
            $query->Where([
                ['first_name', 'like', '%' . $q . '%']
            ]);
        }

        return responsedata(data: ['employee' => (new EmployeeCollection($query->paginate(5)))->response()->getData()]);
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
    public function show(Employee $employee)
    {

        // $employee = Employee::find($id);

        return responsedata(data: [
            'employee' => $employee
        ]);


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


    public function search($search)
    {


        $data = [];
        $columns = ['first_name', 'middle_name', 'last_name', 'mobile', 'gender', 'status', 'Employee_id', 'date_of_birth'];

        foreach ($columns as $column) {
            $model = Employee::where($column, '=', $search)->get();
            if ($model->first() != null) {
                $data[] = ['employee' => $model];
            }
        }

        if (count($data) != 0) {
            return responsedata(data: $data);
        } else {
            return responsedata(msg: "Data is not found pls try again!");
        }
    }
}
