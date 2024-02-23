<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="forgot.css">
    <title>Password recover</title>
</head>

<body>
    <div class="header">
        <div class="list" onclick="location.href = '../index.html'">
            <h4>Вернуться</h4>
        </div>
    </div>
    <div class="container" id="container">
        <?php
        require "texts.php";
        global $current_step;
        // if (!isset($_COOKIE["step"])) setcookie("step", "1");
        // else $current_step = $_COOKIE["step"];
        switch ($current_step) {
            case "1":
                echo $step1;
                break;
            case "2":
                echo $step2;
                break;
            case "3":
                echo $step3;
                break;
            case "none":
                echo "ПИЗДЕЦ!";
                break;
        }
        ?>
    </div>

</body>

</html>