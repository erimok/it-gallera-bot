<?php

use App\API\Receiver;
use App\Bot;
use App\Commands\HelpCommand;
use App\Commands\StartCommand;
use App\Events\BotName\BotNameReaction;
use App\Events\BotName\BotNameReactionFactory;
use App\Handlers\Update\BotNameHandler;
use App\Handlers\Update\CommandsHandler;
use App\Handlers\Update\UpdateHandler;

require_once 'vendor/autoload.php';

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/.env');

$receiver = new Receiver();

$bot_name_reactions = [
    new BotNameReaction('Я занят до 18:00, а в 18:01 меня тут уже не будет 😉'),
    new BotNameReaction('Давай позже поговорим, я еще от твоего прошлого merge request еще не отошел 🤬'),
    new BotNameReaction('Я занят, если что-то срочное - спроси у PM'),
    new BotNameReaction('Будешь много меня дергать - на следующем assessment вернешься на junior!'),
    new BotNameReaction('Опять вопросы?! А что у нас Google и Stackoverflow забанили?'),
    new BotNameReaction('Я могу спокойно кофе попить?!'),
    new BotNameReaction('Когда уже наступит пятница?! 😭'),
    new BotNameReaction('*Чем-то занят*'),
    new BotNameReaction('*Делает вид, что чем-то занят*'),
    new BotNameReaction('Я разрешаю тебе учиться на своих ошибках, только не пингуй меня 🧐'),
    new BotNameReaction('Уже выучил SOLID?! Тогда чего пишешь? 😡'),
    new BotNameReaction('Хочется поговорить?! - Сейчас поговорим за ООП 😈'),
    new BotNameReaction('Я же говорил, что меня звать можно только на coffee break! ☕️'),
];

$bot_name_reactions_factory = new BotNameReactionFactory();
$bot_name_reactions_factory->setReactions($bot_name_reactions);

$command_handler = new CommandsHandler();
$command_handler->getCommandFactory()->setCommands([
    new HelpCommand($receiver),
    new StartCommand($receiver),
]);

$update_handler = new UpdateHandler();
$update_handler->setUpdateEventsHandlers([
    new BotNameHandler($bot_name_reactions_factory, $receiver),
    $command_handler
]);

$bot = new Bot();
$bot->setHandlers([
    $update_handler
]);
$bot->launch();
