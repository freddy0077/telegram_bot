<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing;

use TelegramBot\Entities\Update;
use TelegramBot\Request;
use TelegramBot\Telegram;

class App extends \TelegramBot\UpdateHandler {

    public function __process(Update $update): void {

        Telegram::setAdminId(5309455764);
        $callback_query = $update->getCallbackQuery();

        if ($callback_query) {
            $callback_data = $callback_query->getData();
            $message = $update->getMessage();
            Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => 'Markdown',
                'text' => '`Pong!`',
            ]);
        }

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

            Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => 'Markdown',
                'text' => '`Update query`',
            ]);
            // For demonstration purposes, echo the callback data
            echo $callbackData;

            // Handle specific callback queries (you might need to expand on this)
            if ($callbackData == 'callback:mega_jackpot') {
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'You clicked on the button with "callback:mega_jackpot"',
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


// Handling the callback when 'Play with cash' is pressed
// if ($callbackQuery && $callbackQuery->getData() == 'show_cash_games') {
//            yield Request::editMessageText([
//                'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
//                'message_id' => $callbackQuery->getMessage()->getMessageId(),
//                'text' => "Choose a cash game:",
//                'reply_markup' => InlineKeyboard::make()->setKeyboard([
//                    [InlineKeyboardButton::make('Mega jackpot')->setCallbackData('mega_jackpot')],
//                    [InlineKeyboardButton::make('Direct game')->setCallbackData('direct_game')],
//                    [InlineKeyboardButton::make('Perm game')->setCallbackData('perm_game')]
//                ])
//            ]);
// }