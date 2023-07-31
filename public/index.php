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

        .cafe-item.disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .number-pad {
            display: none; /* start with the number pad hidden */
            flex-wrap: wrap;
            width: 220px; /* control the width of the number pad */
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            position: absolute; /* to allow positioning */
            z-index: 999; /* to ensure it's above other content */
        }

        .number-button {
            width: 40px;
            height: 40px;
            margin: 2px;
            border: 1px solid #ccc;
            background-color: #fff;
            text-align: center;
            line-height: 40px; /* vertically aligns the text */
            cursor: pointer;
            border-radius: 4px; /* rounded corners */
            transition: background-color 0.3s; /* smooth color transition */
        }

        .number-button:hover {
            background-color: #e9e9e9; /* color on hover */
        }

        .number-button.selected {
            background-color: #007bff; /* color when selected */
            color: white; /* text color when selected */
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
<div class="number-pad">
    <div class="numbers">
        <?php for ($i = 1; $i <= 57; $i++): ?>
            <button class="number-button" data-number="<?php echo $i; ?>"><?php echo $i; ?></button>
        <?php endfor; ?>
    </div>
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
            $('.js-item').on('click', function (event) {
                event.stopPropagation(); // Prevent the click from bubbling up

                $('.js-item').addClass('disabled');
                $(this).removeClass('disabled');

                $('.number-pad').css({ // Position the number pad relative to clicked item
                    top: $(this).offset().top + $(this).height() + 5 + "px",
                    left: $(this).offset().left + "px"
                }).show();
            });

            $('.number-button').on('click', function () {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else if ($('.number-button.selected').length < 6) {
                    $(this).addClass('selected');
                }
            });

            $(document).on('click', function (event) {
                if (!$(event.target).closest('.number-pad, .js-item').length) {
                    $('.number-pad').hide();
                    $('.js-item').removeClass('disabled');
                    $('.number-button').removeClass('selected');
                }
            });
        })

</script>
</body>
</html>
