<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing\Plugins;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\KeyboardButton;
use TelegramBot\Entities\Message;
use TelegramBot\Entities\Keyboard;
use TelegramBot\Enums\ParseMode;
use TelegramBot\Request;

class Commands extends \TelegramBot\Plugin
{
    public function onMessage(int $update_id, Message $message): \Generator
    {

        $contact = $message->getContact();

        if ($message->getText() == '/start') {
            // Request phone number
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => "Please share your phone number to get started!",
                'reply_markup' => Keyboard::make()
                    ->setResizeKeyboard(true)
                    ->setOneTimeKeyboard(true)
                    ->setKeyboard([
                        [KeyboardButton::make('Share Phone Number')->setRequestContact(true)]
                    ])
            ]);
        } elseif ($contact && $contact->getPhoneNumber()) {
            $phoneNumber = $contact->getPhoneNumber();
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Thanks for sharing your number. Please tap the button below to choose options!",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('🟢 Play for free')->setCallbackData('free_play')],
                    [InlineKeyboardButton::make('🔴 Play with cash')->setCallbackData('show_cash_games')]
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
    }
}
