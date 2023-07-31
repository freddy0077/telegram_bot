<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\Update;
use TelegramBot\Request;
use TelegramBot\Telegram;

class App extends \TelegramBot\UpdateHandler {

    public function __process(Update $update): void
    {
        Telegram::setAdminId(5309455764);

        if ($message = $update->getMessage()) {
            if ($message->getText() === '/ping') {
                Request::sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'parse_mode' => 'Markdown',
                    'text' => '`Pong!`',
                ]);
            }
        }

        if ($callbackQuery = $update->getCallbackQuery()) {
            $chatId = $callbackQuery->getMessage()->getChat()->getId();
            $callbackData = $callbackQuery->getData();
             if ($callbackQuery->getData() == 'show_cash_games') {
                 Request::editMessageText([
                'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                'message_id' => $callbackQuery->getMessage()->getMessageId(),
                'text' => "Choose a cash game:",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [ InlineKeyboardButton::make('Mega jackpot')->setWebApp("https://telegram.afriluck.com?type=megajackpot")],
                    [InlineKeyboardButton::make('Direct game')->setWebApp("https://telegram.afriluck.com?type=direct")],
                    [InlineKeyboardButton::make('Perm game')->setWebApp("https://telegram.afriluck.com?type=perm")]
                ])
            ]);
             }

            if ($callbackQuery->getData() == 'free_play') {
                 Request::sendMessage([
                    'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                    'text' => "Please type 6 unique numbers from 1 to 57 separated by commas."
                ]);
            }
        }

//        $data = $callback_query->getData();
//        $chat_id = $callback_query->getMessage()->getChat()->getId();
//

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