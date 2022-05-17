<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id', 'joining_date', 'name'
    ];

    public function compannies()
    {
        return $this->belongsToMany(Company::class, Member::class, 'id', 'company_id');
    }
    public function memberHistory()
    {
        return $this->hasMany(MemberHistory::class, 'member_id');
    }
}
