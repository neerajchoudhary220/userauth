<?php

namespace App\Http\Controllers\Mycontroller;

use App\Http\Controllers\Controller;
use App\Http\Resources\MyCollecton;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Member;
use App\Models\MemberHistory;

class MyController extends Controller
{

    public function company_related(Request $request)
    {

        $query = Member::query();
        if ($request->com) {


            return responsedata(data: ['working_members' => Company::find($request->com)->members]);
        }

        if ($request->member) {

            return responsedata(data: ['comapanines' => Member::find($request->member)->compannies]);
        }

        if ($request->member_history) {
            return responsedata(data: ['members_history' => Member::find($request->member_history)->memberHistory]);
        }


        return responsedata(data: ['all_working_members' => Member::all()]);
    }

    public function member_related($id)
    {
        return responsedata(data: [
            'working_company' => Member::find($id)->compannies
        ]);
    }
}
