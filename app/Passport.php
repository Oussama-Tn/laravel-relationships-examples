<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    protected $fillable = [
        'number',
        'date_of_expiry',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
