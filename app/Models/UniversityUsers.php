<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityUsers extends Model
{
    /** @use HasFactory<\Database\Factories\UniversityUsersFactory> */
    protected $table = 'students';
    protected $primaryKey = 'id'; // specify custom primary key

    public $incrementing = true; // if id is an integer and auto-incremented

    protected $keyType = 'int'; // or string, depending on your DB schema


    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'user_role',
        'user_name',
        'full_name',
        'phone',
        'whatsup_number',
        'address',
        'password',
        'email',
        'student_img',
    ];

}
