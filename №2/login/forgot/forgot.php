<?php

require "../db.php";
require "../sendmail.php";
$main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
$main_conn->start([
    "student_records" => ["name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "datetime" => "TEXT"],
    "admin" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]
]);
$main_mail = new Mail();
if (isset($_POST["recover_email"])) {
    $email = addslashes(trim(htmlspecialchars($_POST["recover_email"])));
    $is_exist = $main_conn->get_where("security", ["email" => $email]);
    if ($is_exist !== false) {
        $code = rand(0, 9999);
        $code = strval($code);
        if (strlen($code) < 4) {
            for ($i = 0; $i < 4 - strlen($code); $i++) {
                $code = "0" . $code;
            }
        }
        $message = "Your verification code: " . $code . ". It expires in 5 minutes.";
        $temp = $main_mail->send_mail($email, "Recover password on [eventregister]", $message);
        setcookie("code", $code, time() + 360, "/");
        setcookie("email", $email, time() + 360, "/");
        if (isset($_COOKIE["step"])) setcookie("step", "2", 1, "/");
        header("Location: forgot.html");
    }
} else if (isset($_POST["check_code"])) {
    if ($_POST["check_code"] == $_COOKIE["code"]) {
        setcookie("recover_res", "Успешно!", time() + 120, "/");
        setcookie("step", "3", 1, "/");
    } else setcookie("recover_res", "Неверно набран код! Попробуйте ещё раз", time() + 120);
    header("Location: forgot.html");
} else if (isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
    if ($_POST["new_password"] === $_POST["confirm_password"]) {
        // setcookie("passwd", $_POST["new_password"], time() + 1, "/");
        setcookie("recover_res", "Успешно!", time() + 20, "/");
        setcookie("step", "0", time() + 1, "/");
        $password = addslashes(trim(htmlspecialchars($_POST["new_password"])));
        $email = addslashes(trim(htmlspecialchars($_COOKIE["email"])));
        // var_dump($email, $password);
        $main_conn->update("security", ["password" => $password], ["email" => $email]);
        header("Location: index.html");
    } else setcookie("recover_res", "Ошибка! Пароли не совпадают", time() + 20);
}
