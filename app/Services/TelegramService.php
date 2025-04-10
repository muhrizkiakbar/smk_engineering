<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\AppService;
use Illuminate\Support\Facades\Http;

class TelegramService extends AppService
{
    public static function sendMessage($message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_BOT_CHAT_ID');

        $response = Http::get("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);

        return $response->json();
    }
}
