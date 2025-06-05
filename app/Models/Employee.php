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

    public function advanceSalaries()
    {
        return $this->hasMany(AdvanceSalary::class);
    }
    public function paySalaries()
    {
        return $this->hasMany(PaySalary::class);
    }

    //finding advance salary from AdvanceSalary Table using Employee Model
    //employee object call this method
    public function getAdvanceSalary($month, $year)
    {
        return $this->advanceSalaries()
            ->where('month', $month)
            ->where('year', $year)
            ->first();
    }

    public function hasPaidSalary($month, $year)
    {
        return $this->paySalaries()
            ->where('salary_month', $month)
            ->where('salary_year', $year)
            ->exists();
    }
}
