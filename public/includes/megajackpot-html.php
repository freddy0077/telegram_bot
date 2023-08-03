<?php
$apiEndpoint = 'https://ussd-app.afriluck.com/api/v2/telegram-lottery-games';
$response = file_get_contents($apiEndpoint);
$data = json_decode($response, true);
?>

<section class="cafe-page cafe-items">
    <?php
    foreach ($data['data'] as $item) {
        if ($item['game_type_id'] === "1") {  // Check if game_type_id is 1

            // Convert Unix timestamp to human-readable format (optional)
            $beginTime = date('Y-m-d H:i:s', $item['begin_time'] / 1000);
            $endTime = date('Y-m-d H:i:s', $item['end_time'] / 1000);
            $drawTime = date('Y-m-d H:i:s', $item['draw_time'] / 1000);

            echo '<div class="cafe-item js-item" data-item-id="' . $item['game_id'] . '" data-item-name="megajackpot' . $item['min_price'] . '" data-item-price="' . $item['min_price'] . '">';
            echo '<div class="cafe-item-counter js-item-counter">1</div>';
            echo '<div class="cafe-item-photo">';
            echo '<picture class="cafe-item-lottie js-item-lottie">
                  <source type="application/x-tgsticker" srcset="../img/rsz_lottery-circle.png">
                    <img src="../img/rsz_lottery-circle.png" alt="Burger Picture">
                </picture> ';
            echo '</div>';
            echo '<div class="cafe-item-label">';
            echo '<span class="cafe-item-title">' . $item['name'] . '</span>';
            echo '</div>';
            echo '<div class="cafe-item-buttons">';
            echo '<button class="cafe-item-decr-button js-item-decr-btn button-item ripple-handler">';
            echo '<span class="ripple-mask"><span class="ripple"></span></span>';
            echo '</button>';
            echo '<button class="cafe-item-incr-button js-item-incr-btn button-item ripple-handler">';
            echo '<span class="button-item-label">Play</span>';
            echo '<span class="ripple-mask"><span class="ripple"></span></span>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
    <div class="cafe-item-shadow"></div>
    <div class="cafe-item-shadow"></div>
    <div class="cafe-item-shadow"></div>
    <div class="cafe-item-shadow"></div>
</section>


<!--<section class="cafe-page cafe-items">-->
<!--    <div class="cafe-item js-item" data-item-id="1" data-item-name="megajackpot5" data-item-price="4990">-->
<!--        <div class="cafe-item-counter js-item-counter">1</div>-->
<!--        <div class="cafe-item-photo">-->
<!--            <picture class="cafe-item-lottie js-item-lottie">-->
<!--                <source type="application/x-tgsticker" srcset="../img/rsz_lottery-circle.png">-->
<!--                <img src="../img/rsz_lottery-circle.png" alt="Burger Picture">-->
<!--            </picture>-->
<!--        </div>-->
<!--        <div class="cafe-item-label">-->
<!--            <span class="cafe-item-title">Mega Jackpot</span>-->
<!--            <span class="cafe-item-price">GHS5</span>-->
<!--        </div>-->
<!--        <div class="cafe-item-buttons">-->
<!--            <button class="cafe-item-decr-button js-item-decr-btn button-item ripple-handler">-->
<!--                <span class="ripple-mask"><span class="ripple"></span></span>-->
<!--            </button>-->
<!--            <button class="cafe-item-incr-button js-item-incr-btn button-item ripple-handler">-->
<!--                <span class="button-item-label">Play</span>-->
<!--                <span class="ripple-mask"><span class="ripple"></span></span>-->
<!--            </button>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="cafe-item js-item" data-item-id="2" data-item-name="megajackpot10" data-item-price="1490">-->
<!--        <div class="cafe-item-counter js-item-counter">1</div>-->
<!--        <div class="cafe-item-photo">-->
<!--            <picture class="cafe-item-lottie js-item-lottie">-->
<!--                <source type="application/x-tgsticker" srcset="../img/rsz_lottery-circle.png">-->
<!--                <img src="../img/rsz_lottery-circle.png" alt="Fries Picture">-->
<!--            </picture>-->
<!--        </div>-->
<!--        <div class="cafe-item-label">-->
<!--            <span class="cafe-item-title">Mega Jackpot</span>-->
<!--            <span class="cafe-item-price">GHS10</span>-->
<!--        </div>-->
<!--        <div class="cafe-item-buttons">-->
<!--            <button class="cafe-item-decr-button js-item-decr-btn button-item ripple-handler">-->
<!--                <span class="ripple-mask"><span class="ripple"></span></span>-->
<!--            </button>-->
<!--            <button class="cafe-item-incr-button js-item-incr-btn button-item ripple-handler">-->
<!--                <span class="button-item-label">Play</span>-->
<!--                <span class="ripple-mask"><span class="ripple"></span></span>-->
<!--            </button>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="cafe-item js-item" data-item-id="3" data-item-name="megajackpot20" data-item-price="3490">-->
<!--        <div class="cafe-item-counter js-item-counter">1</div>-->
<!--        <div class="cafe-item-photo">-->
<!--            <picture class="cafe-item-lottie js-item-lottie">-->
<!--                <source type="application/x-tgsticker" srcset="../img/rsz_lottery-circle.png">-->
<!--                <img src="../img/rsz_lottery-circle.png" alt="">-->
<!--            </picture>-->
<!--        </div>-->
<!--        <div class="cafe-item-label">-->
<!--            <span class="cafe-item-title">Mega Jackpot</span>-->
<!--            <span class="cafe-item-price">GHS20</span>-->
<!--        </div>-->
<!--        <div class="cafe-item-buttons">-->
<!--            <button class="cafe-item-decr-button js-item-decr-btn button-item ripple-handler">-->
<!--                <span class="ripple-mask"><span class="ripple"></span></span>-->
<!--            </button>-->
<!--            <button class="cafe-item-incr-button js-item-incr-btn button-item ripple-handler">-->
<!--                <span class="button-item-label">Play</span>-->
<!--                <span class="ripple-mask"><span class="ripple"></span></span>-->
<!--            </button>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="cafe-item-shadow"></div>-->
<!--    <div class="cafe-item-shadow"></div>-->
<!--    <div class="cafe-item-shadow"></div>-->
<!--    <div class="cafe-item-shadow"></div>-->
<!--</section>-->
