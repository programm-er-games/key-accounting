<?php
    require "../db.php";
    $main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
    $main_conn->start(["student_records" => ["name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "datetime" => "TEXT"],
    "security" => ["name" => "TEXT NOT NULL", "surname" => "TEXT", "email" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]]);

    // $email = htmlspecialchars($_POST['sign_in_email']);
    // $password = htmlspecialchars($_POST['sign_in_password']);
    $email = addslashes(trim(htmlspecialchars($_POST["email"])));
    $password = addslashes(trim(htmlspecialchars($_POST["password"])));

    $result = $main_conn->get("security", ["email" => $email, "password" => $password]);
    if ($result === false) {
        echo 'false';
    }
    else {
        header("Location: ../admin/first_page/index.html");
    }
?>