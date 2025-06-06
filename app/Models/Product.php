<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function supplier(){
        $this->belongsTo(Supplier::class);
    }
    public function category(){
        $this->belongsTo(Category::class);
    }
}
