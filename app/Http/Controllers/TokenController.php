<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class TokenController extends Controller
{

    
    public function createToken(Request $request)
    {
        try {
            $request->validate([
                'token_name' => 'required|string|max:255',
                'token_symbol' => 'required|string|max:10|unique:tokens',
                'total_supply' => 'required|numeric|min:1',
                'description' => 'nullable|string'
            ]);

            $user = Auth::user();
            $creationFee = 50; // Token creation cost

            if ($user->balance < $creationFee) {
                return response()->json(['error' => 'Insufficient balance'], 400);
            }

            $admin = User::where('is_admin', true)->first();
            
            DB::transaction(function () use ($user, $request, $creationFee, $admin) {
               
                $user->balance -= $creationFee;
                $user->save();

            
                $admin = User::where('is_admin', true)->first();
                if ($admin) {
                    $admin->balance += $creationFee;
                    $admin->save();
                }

                
                Token::create([
                    'user_id' => $user->id,
                    'token_name' => $request->token_name,
                    'token_symbol' => strtoupper($request->token_symbol),
                    'total_supply' => $request->total_supply,
                    'description' => $request->description,
                    'creation_fee' => $creationFee,
                ]);
            });

            return response()->json([
                'message'           => 'Token created successfully',
                'token_name'        => $request->token_name,
                'token_symbol'      => strtoupper($request->token_symbol),
                'remaining_balance' => $user->balance,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
