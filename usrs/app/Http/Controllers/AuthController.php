<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //Register Api
    public function register(Request $request)
    {


        $request->validate([
            'name' => 'required |string',
            //  'email'=>'required|string|unique:users,email',
            'email' => 'required|string|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|confirmed',
            'username' => 'unique:users,username',
            'role' => 'string'
        ]);

        // $validator = Validator::make(request()->all(), [
        //     'name' => 'required |string',
        //     //  'email'=>'required|string|unique:users,email',
        //     'email' => 'required|string|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
        //     'password' => 'required|string|confirmed',
        //     'username' => 'unique:users,username'
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => $validator->errors()->first('name'),
        //         'errors' => $validator->errors(),
        //         'additional_msg' => 'Bad Request',
        //         'status' => Response::HTTP_BAD_REQUEST,
        //     ], Response::HTTP_BAD_REQUEST);
        // }


        $user_name = User::CreateUsername($request->email);
        $user = User::create([
            //  'username'=>strstr($request->email,'@',$request->email).rand(0,99999),
            'username' => $user_name,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);
        if ($request->role = '' || !isset($request->role)) {
            $r = $user->assignRole('Normal User');
        }
        $r = $user->assignRole('Admin');




        $token = $user->createToken('myapptoken')->plainTextToken;

        // if ($request->role = '') {
        //     $roles = auth()->user()->assignRole('Normal User');
        // } else {
        //     auth()->user()->assignRole($request->role);
        // }

        return responsedata(msg: 'Register Successfully !', data: ['user' => $user->first(), "token" => $token, "roles" => $r->roles->first()]);
    }


    //logout
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return responsedata(msg: 'Logout Successfully !');
    }

    //login

    public function login(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required',
            'password' => 'required|string',
        ]);
        //check username
        $user = User::where('username', $fields['username'])->first();

        //check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {

            return responsedata(msg: 'Invalid username or password', status: 400);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        return responsedata(msg: 'Login in Successfully !', data: ['user' => $user, 'token' => $token]);
    }


    //upload img file
    public function upload(Request $request)
    {


        if ($file = $request->file('file')) {
            $path = $file->store('public/files');
            $name = $file->getClientOriginalName();

            //store your file into directory and db
            $save = new Image();
            $save->title = $name;
            $save->path = $path;
            $save->save();

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file
            ]);
        }
    }
}
