<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    //this is for fillable all column in Employee Table
    protected $guarded = [];

    //or,protected $fillable = [
    //        'name',
    //        'email',
    //        -------
    //        ----
    //    ];
}
