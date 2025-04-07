<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $token;
    protected $url;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->url = "https://api.telegram.org/bot{$this->token}/sendMessage";
    }

    public function sendMessage($chatId, $message)
    {
        return Http::post($this->url, [
            'chat_id' => $chatId,
            'text' => $message
        ])->json();
    }
}
