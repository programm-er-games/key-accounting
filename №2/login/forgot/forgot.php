<?php
require "../../db_v2.php";
require "../../sendmail.php";
// require "texts.php";
$main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
$main_conn->start([
    // "student_records" => ["name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "datetime" => "TEXT"],
    "admin" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]
]);
$main_mail = new Mail();
// echo "test";
// if (!isset($_COOKIE["step"])) setcookie("step", "1", 1, "/");
if (isset($_POST["recover_email"])) {
    // echo "step1";
    $email = addslashes(trim(htmlspecialchars($_POST["recover_email"])));
    $is_exist = $main_conn->get("admin", [], ["email" => $email]);
    if (($is_exist !== false && count($is_exist) > 0) && $email !== "") {
        global $current_step;
        $code = rand(0, 9999);
        $code = strval($code);
        if (strlen($code) < 4) {
            for ($i = 0; $i < 4 - strlen($code); $i++) {
                $code = "0" . $code;
            }
        }
        $message = "Your verification code: " . $code . ". It expires in 5 minutes.";
        $temp = $main_mail->send_mail($email, "Recover password on [eventregister]", $message);
        setcookie("recover_res", "Успешно!", time() + 120);
        setcookie("code", $code, time() + 360, "/");
        // setcookie("email", $email, time() + 360, "/");
        // if (isset($_COOKIE["step"])) 
        setcookie("step", "2", time() + 20, "/");
        // var_dump($current_step);
        // $current_step = "2";
        // var_dump($current_step);
    } else setcookie("recover_res", "Ошибка! Email не найден!", time() + 120);
    header("Location: forgot.html");
} else if (isset($_POST["check_code"])) {
    // global $current_step;
    // echo "step2";
    if ($_POST["check_code"] !== "" && ($_POST["check_code"] == $_COOKIE["code"])) {
        setcookie("recover_res", "Успешно!", time() + 120);
        setcookie("step", "3", 1, "/");
        // $current_step = "3";
    } else setcookie("recover_res", "Неверно набран код! Попробуйте ещё раз", time() + 120);
    header("Location: forgot.html");
} else if (isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
    // global $current_step;
    // echo "step3";
    if ($_POST["new_password"] === $_POST["confirm_password"]) {
        // setcookie("passwd", $_POST["new_password"], time() + 1, "/");
        setcookie("recover_res", "Успешно!", time() + 20);
        setcookie("step", "1", 1, "/");
        $password = addslashes(trim(htmlspecialchars($_POST["new_password"])));
        $email = addslashes(trim(htmlspecialchars($_COOKIE["email"])));
        // var_dump($email, $password);
        $main_conn->update("admin", ["password" => $password], ["email" => $email]);
        setcookie("code", "nrlvnt", 0, "/");
        // setcookie("email", "nrlvnt", 0, "/");
        setcookie("step", "nrlvnt", 0, "/");
        setcookie("recover_res", "nrlvnt", 0);
        header("Location: ../index.html");
    } else {
        setcookie("recover_res", "Ошибка! Пароли не совпадают", time() + 20);
        header("Location: forgot.html");
    }
} else setcookie("recover_res", "Нихуя неверно!!", time() + 20);
