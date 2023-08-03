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

        Request::sendMessage([
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'parse_mode' => 'Markdown',
            'text' => $update->getMessage()->getText(),
        ]);

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

            Request::sendMessage([
                'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('data from callback')]
                ])
            ]);

            if (in_array($callbackQuery->getData(), ['mtn', 'vodafone', 'airteltigo'])) {
                 Request::sendMessage([
                    'chat_id' =>  $callbackQuery->getMessage()->getChat()->getId(),
                    'text' => "Thanks for selecting your mobile network. Now, please tap the button below to choose options!",
                    'reply_markup' => InlineKeyboard::make()->setKeyboard([
                        [InlineKeyboardButton::make('🟢 Play for free')->setCallbackData('free_play')],
                        [InlineKeyboardButton::make('🔴 Play with cash')->setCallbackData('show_cash_games')]
                    ])
                ]);
            }

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

        self::addPlugins([
            Plugins\Commands::class,
            Plugins\WebService::class,
        ]);
    }

    protected function extractNumbers($inputString) {
        preg_match_all('/\d+/', $inputString, $matches);
        return implode('', $matches[0]);
    }
}