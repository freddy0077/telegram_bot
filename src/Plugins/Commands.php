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

        if (preg_match('/^(\d{1,2}[,\s]+){5}\d{1,2}$/', $message->getText())) {
            $numbers = preg_split('/[\s,]+/', $message->getText());

            if (count($numbers) != 6 || count(array_unique($numbers)) != 6 || max($numbers) > 57 || min($numbers) < 1) {
                Request::sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'parse_mode' => 'Markdown',
                    'text' => "Invalid input. Please ensure you're providing 6 distinct numbers between 1 and 57.",
                ]);
            }
        }

        $contact = $message->getContact();
        $text = $message->getText();
        $callback_data = $message->getCallbackQuery() ? $message->getCallbackQuery()->getData() : null;

        if ($text == '/start' || $callback_data == 'back_start') {
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
        } elseif ($contact && $contact->getPhoneNumber() || $callback_data == 'back_network') {
            // Asking for mobile network after phone number has been shared
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => "Please select your mobile network:",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('MTN')->setCallbackData('mtn')],
                    [InlineKeyboardButton::make('Vodafone')->setCallbackData('vodafone')],
                    [InlineKeyboardButton::make('AirtelTigo')->setCallbackData('airteltigo')],
                    [InlineKeyboardButton::make('Back')->setCallbackData('back_start')] // Back button
                ])
            ]);
        } elseif ($text && strpos($text, ',') !== false) {
            // Possible numbers sent by the user, let's validate
            $numbers = explode(',', $text);
            $numbers = array_map('trim', $numbers); // Trim spaces
            $valid = true;

            if (count($numbers) != 6) {
                $valid = false;
            } else {
                foreach ($numbers as $number) {
                    if (!is_numeric($number) || $number < 1 || $number > 57 || count(array_unique($numbers)) != 6) {
                        $valid = false;
                        break;
                    }
                }
            }

            if ($valid) {
                yield Request::sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text' => "Thanks for playing AfriLuck's free lottery. Good luck!"
                ]);
            } else {
                yield Request::sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text' => "Please type 6 unique numbers from 1 to 57 separated by commas.",
                    'reply_markup' => InlineKeyboard::make()->setKeyboard([
                        [InlineKeyboardButton::make('Back')->setCallbackData('back_network')] // Back button
                    ])
                ]);
            }
        } elseif ($text == '/help') {
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
