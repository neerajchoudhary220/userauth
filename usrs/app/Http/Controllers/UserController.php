<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function userLogin(Request $request)
    {
        $request->validate([
            'username'=>'required | string',
            'password'=>'required |string'
        ]);
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            return redirect('home');
        }else{
            return "invalid";
        }

    }

    public function home(Request $request){
            if(Auth::check()){
                return view('welcome');
            }
            else{
                return view('home');
            }
    }

    public function userLogout(){
        Auth::logout();
        // auth()->user()->tokens()->delete();
        return redirect('home');
    }

    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
