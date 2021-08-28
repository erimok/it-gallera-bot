<?php

use App\API\Receiver;
use App\Bot;
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
];

$bot_name_reactions_factory = new BotNameReactionFactory();
$bot_name_reactions_factory->setReactions($bot_name_reactions);

$command_handler = new CommandsHandler();
$command_handler->getCommandFactory()->setCommands([
    StartCommand::NAME => new StartCommand($receiver)
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
