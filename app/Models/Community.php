<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'telegram_id',
        'joined_telegram',
        'instagram_id',
        'joined_instagram',
        'facebook_id',
        'joined_facebook'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
