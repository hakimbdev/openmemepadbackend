<?php

namespace App\Helpers;

class TelegramHelper
{
    public static function verifyTelegramAuth($data)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN'); // Load bot token from .env

        if (!isset($data['hash'])) {
            return false; // If 'hash' is missing, return false
        }

        $checkHash = $data['hash'];
        unset($data['hash']); // Remove hash for signature verification

        // Sort data alphabetically
        ksort($data);
        $dataCheckString = http_build_query($data, '', "\n");

        // Generate the hash using HMAC-SHA256
        $secretKey = hash('sha256', $botToken, true);
        $calculatedHash = hash_hmac('sha256', $dataCheckString, $secretKey);

        return hash_equals($calculatedHash, $checkHash);
    }
}
