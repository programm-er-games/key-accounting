<?php
require "../db.php";
$main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
$main_conn->start([
    "student_records" => ["name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "datetime" => "TEXT"],
    "admin" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]
]);

$result;

if (isset($_POST["email"]) && isset($_POST["password"])) {
    global $result;
    $email = addslashes(trim(htmlspecialchars($_POST["email"])));
    $password = addslashes(trim(htmlspecialchars($_POST["password"])));
    $is_exist = $main_conn->get_where("admin", ["email" => $email, "password" => $password]);
    if ($is_exist === false) {
        $result = 'Нет такой записи';
        header("Location: index.html");
    } else {
        $result = "Успешно!";
        header("Location: ../admin/first_page/index.html");
    }
    setcookie("sign_in_res", $result, time() + 360);
}
