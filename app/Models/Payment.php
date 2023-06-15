<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable=[
        'invoice_id',
        'status',
        'amount',
        'currency_code',
        'user_id'
    ];

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
