<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing;

use TelegramBot\Entities\Update;
use TelegramBot\Request;
use TelegramBot\Telegram;

class App extends \TelegramBot\UpdateHandler {

    public function __process(Update $update): void {

        Telegram::setAdminId(5309455764);

        // Check if the update contains a message
        if ($message = $update->getMessage()) {
            if ($message->getText() === '/ping') {
                Request::sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'parse_mode' => 'Markdown',
                    'text' => '`Pong!`',
                ]);
            }
        }

        // Check if the update contains a callback query
        if ($callbackQuery = $update->getCallbackQuery()) {
            $chatId = $callbackQuery->getMessage()->getChat()->getId();
            $callbackData = $callbackQuery->getData();

            // For demonstration purposes, echo the callback data
            echo $callbackData;

            // Handle specific callback queries (you might need to expand on this)
            if ($callbackData == 'some_callback_data') {
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'You clicked on the button with "some_callback_data"',
                ]);
            }
            // Add more if conditions or switch-case for other callback data
        }

        self::addPlugins([
            Plugins\Commands::class,
            Plugins\WebService::class,
        ]);
    }
}
