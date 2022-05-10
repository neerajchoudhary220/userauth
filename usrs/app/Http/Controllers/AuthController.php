<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Register Api
    public function register(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required |string',
            //  'email'=>'required|string|unique:users,email',
            'email' => 'required|string|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|confirmed',
            'username' => 'unique:users,username'
        ]);

        // $fields =  $request->validate([
        //     'name' => 'required |string',
        //     //  'email'=>'required|string|unique:users,email',
        //     'email' => 'required|string|unique:users,email|regex:/(.+)@(.+)\.(.+)/i',
        //     'password' => 'required|string|confirmed',
        //     'username' => 'unique:users,username'
        // ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first('name'),
                'errors' => $validator->errors(),
                'additional_msg' => 'Bad Request',
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }


        $user_name = User::CreateUsername($request->email);
        $user = User::create([
            //  'username'=>strstr($request->email,'@',$request->email).rand(0,99999),
            'username' => $user_name,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            "data" => [
                'user' => $user,
                'token' => $token,
                'message' => 'Register Successfully !'
            ]

        ];
        return response($response, 201);

        // return User::CreateUsername($fields['email'], $fields['name'], $fields['password']);
    }


    //logout
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        $response = [
            "data" => [
                'user' => '',
                'token' => '',
                'message' => 'Logout Successfully !'
            ]

        ];
        return response([$response, 201]);
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

            return response([
                'message' => 'Username or password invalid !'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            "data" => [
                'user' => $user,
                'token' => $token,
                'message' => 'Logged in Successfully !'
            ]
        ];

        return response($response, 201);
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
