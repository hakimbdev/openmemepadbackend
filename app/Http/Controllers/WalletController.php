<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function storeWallet(Request $request)
    {
        try {
            $request->validate([
                'wallet_id' => 'required|string|unique:wallets,wallet_id'
            ]);

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Store wallet in the wallets table
            $wallet = Wallet::create([
                'user_id'   => $user->id,
                'wallet_id' => $request->wallet_id
            ]);

            return response()->json(['message' => 'Wallet connected successfully', 'wallet' => $wallet]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

        
}
