<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    function members()
    {
        return $this->hasManyThrough(Member::class, Company::class, 'id', 'company_id');
    }
}
