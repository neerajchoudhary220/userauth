<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class MyController extends Controller
{
    function test($name){
        
        return view("testing",['name'=>$name]);
    }

    // function getData(Request $req)
    // {
    
    //     $this->validate($req,[
    //         'firstname'=>'required | max:16 |min:3',
    //         'password'=>'required |max:18| min:5'
    //     ]);
    //    // return DB::select('select * from users');
        
    //     // return redirect('display');
        
    //      return $req->input();
    // }
}