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
</script>



</body>
</html>