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

    private const  METHOD_MAP = [
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

    public function onWebAppData(WebAppData $webAppData): \Generator
    {
        header('Content-Type: application/json');

        $rawData = $webAppData->getRawData();
        $method = $rawData['method'] ?? '';

        switch ($method) {
            case 'makeOrder':
                yield $this->handleMakeOrder($webAppData);
                break;

            case 'checkInitData':
                Response::send(StatusCode::OK);
                break;

            case 'sendMessage':
                yield $this->handleSendMessage($webAppData);
                break;

            default:
                yield $this->handleRequestByDataType($webAppData);
        }
    }

    private function handleMakeOrder(WebAppData $webAppData): \Generator
    {
        yield Request::sendMessage([
            'chat_id' => $webAppData->getUser()->getId(),
            'parse_mode' => ParseMode::MARKDOWN,
            'text' => "Your order has been placed successfully! 🍟" . "\n\n" .
                "Your order is: \n`" . $this->parseOrder($webAppData->getRawData()['order_data']) . "`" . "\n" .
                "Your order will be delivered to you in 30 minutes. 🚚",
        ]);

        Response::send(StatusCode::OK);
    }

    private function handleSendMessage(WebAppData $webAppData): \Generator
    {
        yield Request::sendMessage([
            'chat_id' => $webAppData->getUser()->getId(),
            'parse_mode' => ParseMode::MARKDOWN,
            'text' => "Hello World!",
            ...(!$webAppData->getRawData()['with_webview'] ? [] : [
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('Open WebApp')->setWebApp($_ENV['RESOURCE_BASE_URL'])]
                ])
            ])
        ]);

        Response::send(StatusCode::OK);
    }

    private function handleRequestByDataType(WebAppData $webAppData): \Generator
    {
        $dataType = json_decode($webAppData->getRawData()['order_data'], true)[0]["name"];
        if (isset(self::METHOD_MAP[$dataType])) {
            $numRequired = self::METHOD_MAP[$dataType];

            yield Request::sendMessage([
                'chat_id' => $webAppData->getUser()->getId(),
                'parse_mode' => ParseMode::MARKDOWN,
                'text' => sprintf(
                    "Please type %s between 1 and 57 (separated by spaces or commas) and then press the CONFIRM button below.",
                    $numRequired === 1 ? "1 number" : "$numRequired distinct numbers"
                ),
                'reply_markup' => InlineKeyboard::make()->setKeyboard([
                    [InlineKeyboardButton::make('CONFIRM')->setCallbackData("confirm")]
                ])
            ]);

            Response::send(StatusCode::OK);
        }
    }

    protected function extractNumbers(string $inputString): string
    {
        preg_match_all('/\d+/', $inputString, $matches);
        return implode('', $matches[0]);
    }

}