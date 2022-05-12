<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected  $fillable = [
        'first_name', 'last_name', 'middle_name', 'Employee_id', 'email', 'mobile', 'date_of_birth', 'gender', 'status'
    ];
}
