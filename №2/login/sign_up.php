<?php
require "../db.php";
$main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
$main_conn->start([
    "student_records" => ["name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "datetime" => "TEXT"],
    "security" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]
]);

$result;

if (isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['email']) && isset($_POST['password'])) {
    global $result;
    $name = addslashes(trim(htmlspecialchars($_POST['name'])));
    $surname = addslashes(trim(htmlspecialchars($_POST['surname'])));
    $email = addslashes(trim(htmlspecialchars($_POST['email'])));
    $password = addslashes(trim(htmlspecialchars($_POST['password'])));

    $is_exist = $main_conn->get_where("security", ["name" => $name, "surname" => $surname, "email" => $email, "password" => $password]);
    if ($is_exist === false) {
        $main_conn->insert("security", [$name, $surname, $email, $password]);
        $result = "Вы успешно зарегистрировались!";
        header("Location: index.html");
    } else $result = "Учётная запись с этими данными уже существует. Не хотите ли вы зарегистрироваться?";
    setcookie("sign_up_res", $result, time() + 360);
}
