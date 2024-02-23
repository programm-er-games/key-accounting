<?php
require "../db_v2.php";
$main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
$main_conn->start([
    "admin" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]
]);

$result;

if (isset($_POST["email"]) && isset($_POST["password"])) {
    global $result;
    $email = addslashes(trim(htmlspecialchars($_POST["email"])));
    $password = addslashes(trim(htmlspecialchars($_POST["password"])));
    $is_exist_email = $main_conn->get("admin", ["email"], ["email" => $email]);
    $is_exist_passwd = $main_conn->get("admin", ["password"], ["password" => $password]);
    if ($email === "" && $password === "") {
        $result = "Введите значения!";
        header("Location: index.html");
    } else if ((count($is_exist_email) == 0 && count($is_exist_passwd) == 0)
        || ($is_exist_email === false && $is_exist_passwd === false)
    ) {
        $result = 'Нет такой записи';
        header("Location: index.html");
    } else {
        $user = $main_conn->get("admin", ["password"], ["email" => $email]);
        if ($user[0][0] == $password) {
            $result = "Успешно!";
            header("Location: ../admin/start_page/index.html");
        } else {
            $result = "Неверный пароль!";
            header("Location: index.html");
        }
    }
    setcookie("sign_in_res", $result, time() + 360);
}
