<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Community;

use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function joinCommunity(Request $request)
    {
        try {
        $user = Auth::user();

        $community = Community::updateOrCreate(
            ['user_id' => $user->id],
            [
                'telegram_id' => $request->telegram_id,
                'joined_telegram' => true,
                'instagram_id' => $request->instagram_id,
                'joined_instagram' => true,
                'facebook_id' => $request->facebook_id,
                'joined_facebook' => true,
            ]
        );

        return response()->json(['message' => 'User joined community!', 'data' => $community]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
