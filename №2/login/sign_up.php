<?php
    require "../db.php";
    $main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
    $main_conn->start(["student_records" => ["name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "datetime" => "TEXT"],
    "security" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]]);

    $name = addslashes(trim(htmlspecialchars($_POST['name'])));
    $surname = addslashes(trim(htmlspecialchars($_POST['surname'])));
    $email = addslashes(trim(htmlspecialchars($_POST['email'])));
    $password = addslashes(trim(htmlspecialchars($_POST['password'])));

    $is_exist = $main_conn->get("security", ["name" => $name, "surname" => $surname, "email" => $email, "password" => $password]);
    if ($is_exist === false) {
        $main_conn->insert("security", [$name, $surname, $email, $password]);
        header("Refresh: 0");
    }
    else {
        echo "Учётная запись с этими данными уже существует. Не хотите ли вы зарегистрироваться?";
    }
?>