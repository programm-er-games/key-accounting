<?php
require "../db.php";
$main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
$main_conn->start([
    "student_records" => ["name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "datetime" => "TEXT"],
    "security" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]
]);

// $email = htmlspecialchars($_POST['sign_in_email']);
// $password = htmlspecialchars($_POST['sign_in_password']);

$result;

if (isset($_POST["email"]) && isset($_POST["password"])) {
    global $result;
    $email = addslashes(trim(htmlspecialchars($_POST["email"])));
    $password = addslashes(trim(htmlspecialchars($_POST["password"])));
    $is_exist = $main_conn->get("security", ["email" => $email, "password" => $password]);
    if ($is_exist === false) {
        $result = 'Нет такой записи';
        // echo $result;
        // setcookie("sign_in_res", $result, time() + 360);
        // var_dump($temp);
        // var_dump($_COOKIE);
        // if (isset($_COOKIE["sign_in_res"])) echo $_COOKIE["sign_in_res"];
        // else echo "ПИЗДЕЦ!!";
        header("Location: index.html");
    }
    //  else {
    //     global $result;
    //     $result = 'Успешно!';
    //     header("Location: ../admin/first_page/index.html");
    // }
    setcookie("sign_in_res", $result, time() + 360);
}
