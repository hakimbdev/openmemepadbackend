<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Helpers\TelegramHelper;

class AuthController extends Controller
{
   
    public function usersCount()
    {
        try {
            $userCount =  User::count();

            if($userCount){

                // Return a response
                return response()->json([
                    'status'    =>  200,
                    'message'   => 'user Count successfully',
                    'userCount'     => $userCount,
                ]);

                }else{

                    return response()->json([
                        'status'    => 404,
                        'message'   => 'not fetch user Count',
                        'userCount'     => $userCount,
                    ]);
                }

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
    }

    public function telegramAuth(Request $request)
    {
        try {
        $data = $request->all();

        // Verify Telegram authentication
        if (!TelegramHelper::verifyTelegramAuth($data)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Find or create user based on Telegram ID
        $user = User::firstOrCreate(
            ['telegram_id' => $data['id']],
            [
                'name' => $data['first_name'] . ' ' . ($data['last_name'] ?? ''),
                'email' => $data['id'] . '@telegram.com', 
                'password' => Hash::make(uniqid()), 
                'telegram_username' => $data['username'] ?? null,
                'telegram_chat_id' => $data['chat_id'] ?? null,
            ]
        );

        $token = $user->createToken('telegram-auth')->plainTextToken;
        return response()->json([
            'message' => 'Authentication successful',
            'token' => $token,
            'user' => $user
        ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
