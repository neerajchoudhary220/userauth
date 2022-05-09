<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function CreateUsername($email)
    {
        //Slace username from mail address
        $mail_username = strstr($email, '@', $email);

        //Create unique username and check already username

        $count_usr = 0;
        $check_username = true;


        if (User::where('username', '=', $mail_username)->exists()) {
            do {
                $count_usr = $count_usr + 1;
                $username = $mail_username . '_' . $count_usr; //generate new username
                if (User::where('username', '=', $username)->exists()) //check username
                {
                    //username exist
                    $check_username = true;
                } else {
                    //username not exist
                    $check_username = false;
                }
            } while ($check_username != false);
        } else {


            $username = $mail_username;
        }

        return $username;
    }
}
