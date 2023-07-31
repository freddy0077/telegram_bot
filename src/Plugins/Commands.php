<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing\Plugins;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\KeyboardButton;
use TelegramBot\Entities\Message;
use TelegramBot\Enums\ParseMode;
use TelegramBot\Request;

class Commands extends \TelegramBot\Plugin
{

    public function onMessage(int $update_id, Message $message): \Generator
    {
        $chatStates = [];
//        if ($message->getText() == '/start') {
//
//            // Sending the message with the initial buttons
//            yield Request::sendMessage([
//                'chat_id' => $message->getChat()->getId(),
//                'parse_mode' => ParseMode::MARKDOWN,
//                'text' => "Please tap the button below to choose options!",
//                'reply_markup' => InlineKeyboard::make()->setKeyboard([
//                    [InlineKeyboardButton::make('🟢 Play for free')->setCallbackData('free_play')],
//                    [InlineKeyboardButton::make('🔴 Play with cash')->setCallbackData('show_cash_games')]
//                ])
//            ]);
//        }

        if ($message->getText() == '/start') {

            // Step 1: Ask for phone number
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => "Please share your phone number:",
                'reply_markup' => InlineKeyboard::make()
                    ->setKeyboard([
                        [KeyboardButton::make('📱 Share Phone Number')->setRequestContact(true)],
                    ])
            ]);

            $chatStates[$message->getChat()->getId()] = 'waiting_for_phone';

        } elseif ($message->getContact() && $message->getContact()->getPhoneNumber()) {

            // Assuming that after sharing the phone number, you store it somewhere, e.g., in a database.
            // You can then proceed to Step 2: Ask for network details
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => "Please enter your network details:",
            ]);

            $chatStates[$message->getChat()->getId()] = 'waiting_for_network';

        } elseif (isset($chatStates[$message->getChat()->getId()]) && $chatStates[$message->getChat()->getId()] == 'waiting_for_network') {

            // Save the provided network details and then proceed to Step 3: Display the buttons
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Please tap the button below to choose options!",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('🟢 Play for free')->setCallbackData('free_play')],
                    [InlineKeyboardButton::make('🔴 Play with cash')->setCallbackData('show_cash_games')]
                ])
            ]);
            unset($chatStates[$message->getChat()->getId()]);
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
