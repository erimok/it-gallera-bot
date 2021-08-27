<?php

use App\API\Receiver;
use App\Bot;
use App\Handlers\Update\UpdateHandler;

require_once 'vendor/autoload.php';

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . '/.env');

$receiver = new Receiver();

$update_handler = new UpdateHandler();
$update_handler->getCommandFactory()->setCommands([
    new \App\Commands\StartCommand($receiver)
]);

$bot = new Bot();
$bot->setHandlers([
    $update_handler
]);
$bot->launch();
