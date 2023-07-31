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
    <!-- Added CSS Modifications -->
    <style>
        .cafe-item.disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .number-pad {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .number-button {
            width: 40px;
            height: 40px;
            margin: 5px;
            border: 1px solid #ccc;
            text-align: center;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php
if ($type === "megajackpot") {
    echo include_once 'includes/megajackpot-html.php';
} elseif ($type === "direct") {
    echo include_once 'includes/direct-html.php';
} elseif ($type === "perm") {
    echo include_once 'includes/perm-html.php';
} else {
    echo 'No Menu';
}
?>

<!-- Number pad addition -->
<div class="number-pad" style="display:none;">
    <div class="numbers">
        <?php for ($i = 1; $i <= 57; $i++): ?>
            <button class="number-button" data-number="<?php echo $i; ?>"><?php echo $i; ?></button>
        <?php endfor; ?>
    </div>
    <button class="deselect">Deselect Item</button>
</div>

<?php echo include_once 'includes/cafe-order-overview.php' ?>

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

    // Added JavaScript Modifications
    $(document).ready(function () {
        $('.js-item').on('click', function () {
            $('.js-item').addClass('disabled');
            $(this).removeClass('disabled');
            $('.number-pad').show();
        });

        $('.number-button').on('click', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else if ($('.number-button.selected').length < 6) {
                $(this).addClass('selected');
            }
        });

        $('.deselect').on('click', function () {
            $('.js-item').removeClass('disabled');
            $('.number-pad').hide();
            $('.number-button').removeClass('selected');
        });
    });
</script>
</body>
</html>
