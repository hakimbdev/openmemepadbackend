<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\MiningController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\StakingController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function () {
    return response()->json([
        'message' => 'Connected successfully!'
    ]);
});

// Authentication Routes //
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'telegramAuth']);
Route::get('/users-count', [AuthController::class, 'usersCount']);

// Mining Routes //
Route::post('/save-data', [MiningController::class, 'saveData']);
Route::get('/fetch-data', [MiningController::class, 'fetchData']);
Route::post('/start-mining', [MiningController::class, 'startMining']);
Route::post('/stop-mining', [MiningController::class, 'stopMining']);

//staking route // 
Route::post('/stake', [StakingController::class, 'stake']);
Route::post('/unstake/{id}', [StakingController::class, 'unstake']);
Route::get('/stakes', [StakingController::class, 'getUserStakes']);
Route::get('/pools', [StakingController::class, 'getPools']);

// Telegram Routes //
Route::post('/telegram/webhook', [TelegramController::class, 'handleWebhook']);
Route::get('/send-message', [TelegramController::class, 'sendMessage']);
Route::post('/join-telegram', [TelegramController::class, 'joinTelegram']);
Route::get('/community-members', [TelegramController::class, 'communityMembers']);


// token route //
Route::post('/create-token', [TokenController::class, 'createToken']);

// wallet route //
Route::middleware('auth:sanctum')->post('/connect-wallet', [WalletController::class, 'storeWallet']);
 // join community //
Route::middleware('auth:sanctum')->post('/join-community', [CommunityController::class, 'joinCommunity']);

// Route::post('/auth/telegram', function (Request $request) {
//     $data = $request->validate([
//         'id' => 'required|numeric',
//         'first_name' => 'nullable|string',
//         'last_name' => 'nullable|string',
//         'username' => 'nullable|string',
//         'photo_url' => 'nullable|string',
//         'hash' => 'required|string',
//     ]);

//     // Verify Telegram hash
//     $token = env('TELEGRAM_BOT_TOKEN');
//     $checkHash = hash_hmac('sha256', collect($data)->except('hash')->map(fn($value, $key) => "$key=$value")->sortKeys()->join("\n"), hash('sha256', $token, true));

//     if (!hash_equals($checkHash, $data['hash'])) {
//         return response()->json(['error' => 'Unauthorized'], 403);
//     }

//     // Find or create user
//     $user = User::updateOrCreate(
//         ['telegram_id' => $data['id']],
//         [
//             'first_name' => $data['first_name'] ?? '',
//             'last_name' => $data['last_name'] ?? '',
//             'username' => $data['username'] ?? '',
//             'photo_url' => $data['photo_url'] ?? '',
//         ]
//     );

//     return response()->json(['user' => $user, 'message' => 'Authenticated successfully']);
// });




