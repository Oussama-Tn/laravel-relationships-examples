<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{

    protected $fillable = [
        'user_id',
        'date',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
