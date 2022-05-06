<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Image;

class AuthController extends Controller
{
    //register
public function register(Request $request){
 $fields = $request->validate([
     'name'=>'required |string',
     'email'=>'required|string|unique:users,email',
     'password'=>'required|string|confirmed',
     'username'=>'unique:users,username'
 ]);

 $mail_username = strstr($request->email,'@',$request->email);

            $check_username=true;
            $count_usr=0;
            while($check_username!=false)
            {
                $count_usr = $count_usr+1;

                $username= $mail_username.'_'.$count_usr;
                if(User::where('username','=',$username)->exists())
                {
                        //username exist
                    $check_username =true;
                }
                else{
                        //username not exist
                        $check_username=false;
                }
            }



 $user = User::create([
    //  'username'=>strstr($request->email,'@',$request->email).rand(0,99999),
    'username'=>$username,
     'name'=>$fields['name'],
     'email'=>$fields['email'],
     'password'=>bcrypt($fields['password'])
 ]);

 $token = $user->createToken('myapptoken')->plainTextToken;
 $response =[
     "data"=>[
        'user'=>$user,
        'token'=>$token,
        'message'=>'Register Successfully !'
     ]

 ];

 return response($response, 201);
    }


    //logout
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        $response =[
            "data"=>[
               'user'=>'',
               'token'=>'',
               'message'=>'Logout Successfully !'
            ]

        ];
        return response([$response,201]);
    }

//login

public function login(Request $request){
    $fields = $request->validate([
        'username'=>'required',
        'password'=>'required|string',
    ]);
    //check username
   $user = User::where('username',$fields['username'])->first();

   //check password
   if(!$user || !Hash::check($fields['password'], $user->password)){

return response([
    'message'=>'Username or password invalid !'
], 401);
   }

    $token = $user->createToken('myapptoken')->plainTextToken;
    $response =[
        "data"=>[
           'user'=>$user,
           'token'=>$token,
           'message'=>'Logged in Successfully !'
        ]
        ];

    return response($response, 201);
       }

//update
 public function update(Request $request){
   $user = $request->user();

// dd($user);

        // $user = User::where('username',$request->username)->first();

            $fields = $request->validate([
                'name'=>'required |string',
            ]);

            $user->update([
                'name'=>$fields['name'],
            ]);


        $response =[
            "data"=>[
               'user'=>$user,
               'token'=>'',
               'message'=>'Name updated successfully !'
            ]
            ];

           return response($response,201);
       }



       public function updateUsername(Request $request)
       {
          $user = $request->user();
            if(User::where('username','=',$request->username)->exists())
            {
                $response =[
                    "data"=>[
                       'user'=>$user,
                       'token'=>'',
                       'message'=>'This username already exist !'
                    ]
                    ];
                return response($response,401);

            }
            else{
                $user->update([
                    'username'=>$request->username
                ]);

                $response =[
                    "data"=>[
                       'user'=>$user,
                       'token'=>'',
                       'message'=>'Username updated successfully !'
                    ]
                    ];
            }
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
               $save->path= $path;
               $save->save();

               return response()->json([
                   "success" => true,
                   "message" => "File successfully uploaded",
                   "file" => $file
               ]);

           }


       }


}
