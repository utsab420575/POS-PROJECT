<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaySalary extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Employee(){
        $this->belongsTo(Employee::class);
    }
}
