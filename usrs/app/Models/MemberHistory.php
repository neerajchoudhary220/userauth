<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id', 'company_id', 'joining_date', 'resign_date'
    ];
}
