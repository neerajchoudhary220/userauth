<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    //update name
    public function update(Request $request)
    {
        $user = $request->user();

        // dd($user);

        // $user = User::where('username',$request->username)->first();

        $fields = $request->validate([
            'name' => 'required |string',
        ]);

        $user->update([
            'name' => $fields['name'],
        ]);


        $response = [
            "data" => [
                'user' => $user,
                'token' => '',
                'message' => 'Name updated successfully !'
            ]
        ];

        return response($response, 201);
    }

    //update username
    public function updateUsername(Request $request)
    {
        $fields = $request->validate([
            'username' => 'unique:users,username'
        ]);
        $user = $request->user();
        $user->update([
            'username' => $fields['username']
        ]);

        $response = [
            "data" => [
                'user' => $user,
                'token' => '',
                'message' => 'Username updated successfully !'
            ]
        ];
        return response($response, 201);
    }
}
