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
        $callback_query = $update->getCallbackQuery();

        if ($callback_query) {
            $callback_data = $callback_query->getData();
            $message = $update->getMessage();
            Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => 'Markdown',
                'text' => $callback_data,
            ]);
        }

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
            if ($callbackData == 'show_cash_games') {
                Request::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Show cash games",
                ]);
            }
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