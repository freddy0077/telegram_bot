<?php declare(strict_types=1);

namespace ShahradElahi\DurgerKing\Plugins;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\WebAppData;
use TelegramBot\Enums\ParseMode;
use TelegramBot\Request;
use Utilities\Routing\Response;
use Utilities\Routing\Utils\StatusCode;

/**
 * Class WebService
 *
 * The Class will handle the requests for the WebApp.
 *
 * @author     Shahrad Elahi <shahrad@litehex.com>
 * @link       https://github.com/telegram-bot-php/durger-king
 * @version    v1.0.0
 */
class WebService extends \TelegramBot\Plugin
{

    /**
     * @param WebAppData $webAppData
     * @return \Generator
     */
    public function onWebAppData(WebAppData $webAppData): \Generator
    {

        $methodMap = [
            "megajackpot5" => 6,
            "megajackpot10" => 6,
            "megajackpot20" => 6,
            "direct1" => 1,
            "direct2" => 2,
            "direct3" => 3,
            "direct4" => 4,
            "direct5" => 5,
            "direct6" => 6,
            "perm2" => 3,
            "perm4" => 4,
            "perm5" => 5,
            "perm6" => 6,
        ];

        $dataType = json_decode($webAppData->getRawData()['order_data'], true)[0]["name"];

        if (isset($methodMap[$dataType])) {
            header('Content-Type: application/json');
            $numRequired = $methodMap[$dataType];
            $amount = $this->extractNumbers($methodMap);

            if (str_contains($dataType, "megajackpot")){
                yield Request::sendMessage([
                    'chat_id' => $webAppData->getUser()->getId(),
                    'parse_mode' => ParseMode::MARKDOWN,
                    'text' => "Please type " . ($numRequired == 1 ? "1 number" : "$numRequired distinct numbers") . " between 1 and 57 (separated by spaces or commas).",
                    'reply_markup' => InlineKeyboard::make()->setKeyboard([
                        [InlineKeyboardButton::make('PAY '. $amount. 'GHS')->setCallbackData($dataType)]
                    ])
                ]);
            }else{
                yield Request::sendMessage([
                    'chat_id' => $webAppData->getUser()->getId(),
                    'parse_mode' => ParseMode::MARKDOWN,
                    'text' => "Please type " . ($numRequired == 1 ? "1 number" : "$numRequired distinct numbers") . " between 1 and 57 (separated by spaces or commas).",
                    'reply_markup' => InlineKeyboard::make()->setKeyboard([
                        [InlineKeyboardButton::make('HOW MUCH DO YOU WANT  TO START WITH?')->setCallbackData($dataType)]
                    ])
                ]);
            }

            Response::send(StatusCode::OK);
        }



        if ($webAppData->getRawData()['method'] == "makeOrder") {
            header('Content-Type: application/json');

            yield Request::sendMessage([
                'chat_id' => $webAppData->getUser()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Your order has been placed successfully! 🍟" . "\n\n" .
                    "Your order is: \n`" . $this->parseOrder($webAppData->getRawData()['order_data']) . "`" . "\n" .
                    "Your order will be delivered to you in 30 minutes. 🚚",
            ]);

            Response::send(StatusCode::OK);
        }

        if ($webAppData->getRawData()['method'] == "checkInitData") {
            header('Content-Type: application/json');
            Response::send(StatusCode::OK);
        }

        if ($webAppData->getRawData()['method'] == "sendMessage") {
            header('Content-Type: application/json');

            yield Request::sendMessage([
                'chat_id' => $webAppData->getUser()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => "Hello World!",
                ...(!$webAppData->getRawData()['with_webview'] ? [] : [
                    'reply_markup' => InlineKeyboard::make()->setKeyboard([
                        [
                            InlineKeyboardButton::make('Open WebApp')->setWebApp($_ENV['RESOURCE_BASE_URL']),
                        ]
                    ])
                ])
            ]);

            Response::send(StatusCode::OK);
        }
    }

    /**
     * @param string $order
     * @return string
     */
    protected function parseOrder(string $order = '[]'): string
    {
        if ($order == '[]') {
            return 'Nothing';
        }

        $order = json_decode($order, true);
        $order_text = '';
        foreach ($order as $item) {
            $order_text .= (
                $item['count'] . 'x ' .
                $this->store_items[$item['id']]['name'] . ' ' .
                $this->store_items[$item['id']]['emoji'] . ' $' .
                ($this->store_items[$item['id']]['price'] * $item['count']) . "\n"
            );
        }
        return $order_text;
    }


    /**
     * The available items in the store.
     *
     * @var array|array[]
     */
    protected array $store_items = [
        1 => [
            'name' => 'Burger',
            'emoji' => '🍔',
            'price' => 5,
        ],
        2 => [
            'name' => 'Fries',
            'emoji' => '🍟',
            'price' => 2,
        ],
        3 => [
            'name' => 'Drink',
            'emoji' => '🥤',
            'price' => 1,
        ],
        4 => [
            'name' => 'Salad',
            'emoji' => '🥗',
            'price' => 3,
        ],
        5 => [
            'name' => 'Pizza',
            'emoji' => '🍕',
            'price' => 4,
        ],
        6 => [
            'name' => 'Sandwich',
            'emoji' => '🥪',
            'price' => 3,
        ],
        7 => [
            'name' => 'Hot Dog',
            'emoji' => '🌭',
            'price' => 2,
        ],
        8 => [
            'name' => 'Ice Cream',
            'emoji' => '🍦',
            'price' => 2,
        ],
        9 => [
            'name' => 'Cake',
            'emoji' => '🍰',
            'price' => 3,
        ],
        10 => [
            'name' => 'Donut',
            'emoji' => '🍩',
            'price' => 1,
        ],
        11 => [
            'name' => 'Cupcake',
            'emoji' => '🧁',
            'price' => 1,
        ],
        12 => [
            'name' => 'Cookie',
            'emoji' => '🍪',
            'price' => 1,
        ],
        13 => [
            'name' => 'Sushi',
            'emoji' => '🍣',
            'price' => 4,
        ],
        14 => [
            'name' => 'Noodles',
            'emoji' => '🍜',
            'price' => 3,
        ],
        15 => [
            'name' => 'Steak',
            'emoji' => '🥩',
            'price' => 5,
        ],
    ];

    protected function extractNumbers($inputString) {
        preg_match_all('/\d+/', $inputString, $matches);
        return implode('', $matches[0]);
    }

}