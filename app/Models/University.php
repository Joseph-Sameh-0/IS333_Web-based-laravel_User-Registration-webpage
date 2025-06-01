<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    /** @use HasFactory<\Database\Factories\UniversityFactory> */
    protected $table = 'students';
    use HasFactory;
    protected $fillable = ['user_role','user_name','full_name','phone','whatsup_number','address','password','email','student_img'];
}
