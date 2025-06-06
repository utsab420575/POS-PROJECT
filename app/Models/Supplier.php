<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function product(){
        return $this->hasMany(Product::class);
    }
}
