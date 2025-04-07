<?php

namespace App\Http\Controllers;
use App\Models\StakingPool;
use App\Models\UserStake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class StakingController extends Controller
{
    public function stake(Request $request) {
        $user = Auth::user();
        
        $request->validate([
            'staking_pool_id' => 'required|exists:staking_pools,id',
            'amount' => 'required|numeric|min:0.001',
        ]);
    
        $stakingPool = StakingPool::find($request->staking_pool_id);
        
        UserStake::create([
            'user_id' => $user->id,
            'staking_pool_id' => $stakingPool->id,
            'amount_staked' => $request->amount,
            'staked_at' => now(),
        ]);
    
        return response()->json(['message' => 'Staking successful!'], 200);
    }


    public function unstake($id)
    {
        $stake = UserStake::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if (!$stake->is_active) {
            return response()->json(['message' => 'Already unstaked'], 400);
        }

        if (Carbon::now()->lt($stake->unstake_at)) {
            return response()->json(['message' => 'Staking period not yet over'], 400);
        }

        // Mark as unstaked
        $stake->update(['is_active' => false]);

        return response()->json(['message' => 'Unstaked successfully']);
    }
    
}
