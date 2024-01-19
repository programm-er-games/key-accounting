<?php
    require "../db.php";
    $main_conn = new Db("C:\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
    $main_conn->start("records", "name TEXT NOT NULL", "surname TEXT NOT NULL", "datetime TEXT");

    $email = htmlspecialchars($_POST['sign_in_email']);
    $password = htmlspecialchars($_POST['sign_in_password']);

    $result = $main_conn->get("records", ["name" => ""]);