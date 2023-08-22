<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJobRole extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'user_id',
        'job_role_id'
    ];
}
