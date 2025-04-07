<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stake extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'pool_id', 'amount', 'apr', 'staked_at', 'unstaked_at'];

    public function pool()
    {
        return $this->belongsTo(LiquidityPool::class, 'pool_id');
    }

    public function calculateRewards()
    {
        if (!$this->unstaked_at) {
            $days = now()->diffInDays($this->staked_at);
            return ($this->amount * ($this->apr / 100) / 365) * $days;
        }
        return 0;
    }
}
