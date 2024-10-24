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
        if ($bot->message()->from->username !== $_ENV['bot_owner_username']) {
            $this->end();
            return;
        }

        $bot->sendMessage('Че отправляем?');
        $this->next('send');
    }

    public function send(Nutgram $bot)
    {
        $users = Chat::all();
        $bot->sendMessage('Отправляю ' . count($users) . ' пользователям...');

        $success = 0;
        foreach ($users as $user) {
            $success += $bot->message()->copy($user->id) instanceof MessageId;
        }

        $bot->sendMessage("Отправил $success пользователям");
        $this->end();
    }
}