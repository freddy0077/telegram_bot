<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing\Plugins;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\Message;
use TelegramBot\Enums\ParseMode;
use TelegramBot\Request;

/**
 * Class Commands
 *
 * The Class will handle the requests for the WebApp.
 *
 * @author     Shahrad Elahi <shahrad@litehex.com>
 * @link       https://github.com/telegram-bot-php/durger-king
 * @version    v1.0.0
 */
class CommandsDeprecated extends \TelegramBot\Plugin
{

    /**
     * @param int $update_id
     * @param Message $message
     * @return \Generator
     */
    public function onMessage(int $update_id, Message $message): \Generator
    {
        // if ($message->getText() == '/start' || $message->getText() == '/order') {
        //     yield Request::sendMessage([
        //         'chat_id' => $message->getChat()->getId(),
        //         'parse_mode' => ParseMode::MARKDOWN,
        //         // 'text' => "*Let's get started* 🍟 \n\nPlease tap the button below to choose options!",
        //         'text' => "*Let's get started* \n\nPlease tap the button below to choose options!",
        //         'reply_markup' => InlineKeyboard::make()->setKeyboard([
        //             [
        //                 // InlineKeyboardButton::make('Order Food')->setWebApp($_ENV['RESOURCE_PATH']),
        //                 InlineKeyboardButton::make('Play Lottery')->setWebApp("https://telegram.afriluck.com/"),
        //             ]
        //         ])
        //     ]);
        // }

        if ($message->getText() == '/start' || $message->getText() == '/order') {
            // Sending the image
            // yield Request::sendPhoto([
            //     'chat_id' => $message->getChat()->getId(),
            //     'photo' => 'http://afriluckstaging3.afriluck.com/assets/carousels/cr-desk-6b.jpg',
            //     'caption' => "*Let's get started*",  
            //     'parse_mode' => ParseMode::MARKDOWN,
            // ]);
            
            // Sending the message with the button
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Please tap the button below to choose options!",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [
                        InlineKeyboardButton::make('Play Lottery')->setWebApp("https://telegram.afriluck.com/"),
                    ]
                ])
            ]);

//            yield Request::sendMessage([
//                'chat_id' => $message->getChat()->getId(),
//                'parse_mode' => ParseMode::MARKDOWN,
//                'text' => "Please tap the button below to choose options!",
//                'reply_markup' => InlineKeyboard::make()->setKeyboard([
//                    [
//                        InlineKeyboardButton::make('Play Lottery')->setWebApp("https://telegram.afriluck.com/"),
//                    ]
//                ])
//            ]);
        }
        

        if ($message->getText() == '/test') {
            yield Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Please tap the button below to open the web app!",
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [
                        InlineKeyboardButton::make('Test')->setWebApp($_ENV['RESOURCE_PATH'] . '/demo.php'),
                    ]
                ])
            ]);
        }

        // if ($message->getText() == '/help') {
        //     yield Request::sendMessage([
        //         'chat_id' => $message->getChat()->getId(),
        //         'text' => "This is the help page. You can use the following commands:\n\n" .
        //             "/start - Start the bot\n" .
        //             "/order - Order a burger\n" .
        //             "/test - Test the web app\n" .
        //             "/help - Show this help page"
        //     ]);
        // }

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