<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing\Plugins;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\Message;
use TelegramBot\Enums\ParseMode;
use TelegramBot\Request;

class Commands extends \TelegramBot\Plugin
{

    public function onMessage(int $update_id, Message $message): \Generator
    {
        if ($message->getText() == '/start' || $message->getText() == '/order') {

            // Sending the message with the initial buttons
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Please tap the button below to choose options!",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('🔵 Play Lottery')->setWebApp("https://telegram.afriluck.com/")],
                    [InlineKeyboardButton::make('🟢 Play for free')->setCallbackData('free_play')],
                    [InlineKeyboardButton::make('🔴 Play with cash')->setCallbackData('show_cash_games')]
                ])
            ]);
        }

        if ($message->getText() == '/test') {
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Please tap the button below to open the web app!",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('Test')->setWebApp($_ENV['RESOURCE_PATH'] . '/demo.php')]
                ])
            ]);
        }

        if ($message->getText() == '/help') {
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => "This is the help page. You can use the following commands:\n\n" .
                    "/start - Start the bot\n" .
                    "/results - Last results\n" .
                    "/history - Transaction history\n" .
                    "/help - Show this help page"
            ]);
        }

        // Handling the callback when 'Play with cash' is pressed
        // if ($callbackQuery && $callbackQuery->getData() == 'show_cash_games') {
            yield Request::editMessageText([
                'chat_id' => $callbackQuery->getMessage()->getChat()->getId(),
                'message_id' => $callbackQuery->getMessage()->getMessageId(),
                'text' => "Choose a cash game:",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('Mega jackpot')->setCallbackData('mega_jackpot')],
                    [InlineKeyboardButton::make('Direct game')->setCallbackData('direct_game')],
                    [InlineKeyboardButton::make('Perm game')->setCallbackData('perm_game')]
                ])
            ]);
        // }
    }
}
