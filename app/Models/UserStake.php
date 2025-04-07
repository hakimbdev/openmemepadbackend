<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStake extends Model
{
    public function calculateRewards($userStake) {
        $stakingPool = $userStake->stakingPool;
        $daysStaked = now()->diffInDays($userStake->staked_at);
        
        $apr = $stakingPool->apr / 100;
        $yearlyReward = $userStake->amount_staked * $apr;
        $dailyReward = $yearlyReward / 365;
        
        return $dailyReward * $daysStaked;
    }
    
}
