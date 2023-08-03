<?php
$type = $_GET['type'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AfriLuck Lottery</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, viewport-fit=cover"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="MobileOptimized" content="176"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="robots" content="noindex, nofollow"/>
    <script src="https://tg.dev/js/telegram-web-app.js?7"></script>
    <script>
        function setThemeClass() {
            document.documentElement.className = Telegram.WebApp.colorScheme;
        }

        Telegram.WebApp.onEvent('themeChanged', setThemeClass);
        setThemeClass();
    </script>
    <link href="css/cafe.css" rel="stylesheet">
</head>
<body>

<?php
if ( $type === "megajackpot"){
    echo include_once 'includes/megajackpot-html.php';

}elseif ($type === "direct"){
    echo include_once 'includes/direct-html.php';
}
elseif ($type === "perm"){
    echo include_once 'includes/perm-html.php';
}
else {
    echo 'No Menu';
}
?>

<?php echo include_once 'includes/cafe-order-overview.php'?>

<div class="cafe-status-wrap">
    <div class="cafe-status js-status"></div>
</div>
<script src="https://tg.dev/js/jquery.min.js"></script>
<script src="https://tg.dev/js/tgsticker.js?27"></script>
<script src="js/cafe.js?version=<?php echo uniqid() ?>"></script>
<script>
    Cafe.init({
        "apiUrl": "https://telegram.afriluck.com/telegram",
        "userId": 0,
        "userHash": null
    });

    document.addEventListener("DOMContentLoaded", function() {

        // Define the URL for your API endpoint
        const apiEndpoint = 'https://yourapiendpoint.com/data';

        fetch(apiEndpoint)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                let htmlContent = '';

                data.forEach(item => {
                    htmlContent += `
                    <div class="cafe-item js-item" data-item-id="${item.id}" data-item-price="${item.price}">
                        <div class="cafe-item-counter js-item-counter">${item.counter}</div>
                        <div class="cafe-item-photo">
                            <picture class="cafe-item-lottie js-item-lottie">
                                <source type="application/x-tgsticker" srcset="${item.imageSrc}">
                                <img src="${item.imageSrc}" alt="${item.altText}">
                            </picture>
                        </div>
                        <div class="cafe-item-label">
                            <span class="cafe-item-title">${item.title}</span>
                            <span class="cafe-item-price"></span>
                        </div>
                        <div class="cafe-item-buttons">
                            <button class="cafe-item-decr-button js-item-decr-btn button-item ripple-handler">
                                <span class="ripple-mask"><span class="ripple"></span></span>
                            </button>
                            <button class="cafe-item-incr-button js-item-incr-btn button-item ripple-handler">
                                <span class="button-item-label">${item.buttonLabel}</span>
                                <span class="ripple-mask"><span class="ripple"></span></span>
                            </button>
                        </div>
                    </div>`;
                });

                document.querySelector('#yourContainerId').innerHTML = htmlContent;
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error.message);
            });

    });

</script>

</body>
</html>