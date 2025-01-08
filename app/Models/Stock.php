<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [

        'item_code',
        'item_name',
        'quantity',
        'location',
        'store_id',
        'status',
        'in_stock_date',
        'created_by',
    ];

    public function store(){
        return $this->hasOne(Store::class, 'id', 'store_id');
    }
}
