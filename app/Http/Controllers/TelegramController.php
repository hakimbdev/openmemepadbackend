<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class TelegramController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Log the received request
        Log::info('Received Telegram Update:', $request->all());

        // Extract chat ID and message text
        $data = $request->all();
        $chatId = $data['message']['chat']['id'] ?? null;
        $messageText = strtolower($data['message']['text'] ?? '');

        if ($chatId) {
            // Check for commands
            if ($messageText == "/start") {
                $responseMessage = "Welcome! I'm your mining bot. Use /help to see available commands.";
            } elseif ($messageText == "/help") {
                $responseMessage = "Here are my commands:\n/start - Start bot\n/help - Show commands";
            } else {
                $responseMessage = "I didn't understand that. Type /help for a list of commands.";
            }

            Http::post("https://api.telegram.org/7883546538:AAE3jN83w_tyBYOCutP0VC-iLCI4UyceIRo" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
                'chat_id' => $chatId,
                'text' => $responseMessage
            ]);
        }

        return response()->json(['status' => 'success']);
    }


    public function sendMessage($chatId, $message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message
        ]);

        return $response->json();
    }


    public function joinTelegram(Request $request)
    {
        $request->validate([
            'telegram_id' => 'required|numeric|unique:users,telegram_id'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user->telegram_id = $request->telegram_id;
        $user->joined_telegram = true;
        $user->save();

        return response()->json(['message' => 'User joined Telegram successfully']);
    }

    public function communityMembers()
    {
        $communityMembers = User::where('joined_telegram', true)->get(['id', 'name', 'telegram_id']);

        return response()->json(['community_members' => $communityMembers]);
    }

}
