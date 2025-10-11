<?php

namespace App\Models;
use App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable =[
        'user_id',
        'customer_id',
        'total',
        'discount',
        'vat',
        'payable'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
   
}
