<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Stake;
class LiquidityPool extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'tvl', 'apr'];

    public function stakes()
    {
        return $this->hasMany(Stake::class, 'pool_id');
    }
}
