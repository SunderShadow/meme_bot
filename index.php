<?php

use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;

require "vendor/autoload.php";

$_ENV = require __DIR__ . DIRECTORY_SEPARATOR . 'env.php';

echo
    "PID: ", getmypid(), PHP_EOL,
    'Bot config:', PHP_EOL,
    json_encode($_ENV, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), PHP_EOL;

$bot = new Nutgram($_ENV['token'], new Configuration(
    botName: $_ENV['bot_name'],
    clientOptions: [
        'verify' => false
    ]
));

$bot->onCommand('start', function (Nutgram $bot) {
    \Core\Chat::create($bot->message()->chat->id);
});

$bot
    ->onCommand('memaser@start', function (Nutgram $bot) {
        \Core\Chat::create($bot->message()->chat->id);
    })
    ->scope(new \SergiX44\Nutgram\Telegram\Types\Command\BotCommandScopeAllGroupChats())
    ->description('Начниается игра')
;

$bot->onCommand('send', \Core\Conversation\SendMeme::class);

$bot->run();
