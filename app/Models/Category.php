<?php

namespace App\Models;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'user_id'
    ];
    public function user (){
        $this->belongsTo(User::class);
    }
    public function products (){
        $this->belongsTo(Product::class);
    }
}
