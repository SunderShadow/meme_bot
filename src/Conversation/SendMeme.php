<?php

namespace Core\Conversation;

use Core\Chat;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\MessageId;

class SendMeme extends Conversation
{
    public function start(Nutgram $bot)
    {
        if (!in_array($bot->message()->from->username, $_ENV['bot_privileged_users'])) {
            $this->end();
            return;
        }

        $bot->sendMessage('Че отправляем?');
        $this->next('send');
    }

    public function send(Nutgram $bot)
    {
        $chats = Chat::all();
        $bot->sendMessage('Отправляю ' . count($chats) - 1 .' пользователям...');

        $success = 0;
        foreach ($chats as $chat) {
            if ($bot->chatId() !== $chat->id) {
                $success += $bot->message()->copy($chat->id) instanceof MessageId;
            }
        }

        $bot->sendMessage("Отправил $success пользователям");
        $this->end();
    }
}