<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
   protected $fillable = [

        'user_id',
        'token_name',
        'token_symbol',
        'total_supply',
        'description',
        'creation_fee'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
