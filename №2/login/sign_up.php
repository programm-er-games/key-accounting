<?php
    require "../db.php";
    $datetime = new DateTime(timezone: new DateTimeZone("+0300"));
    $main_conn = new Db("C:\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
    $main_conn->start("records", "name TEXT NOT NULL", "surname TEXT NOT NULL", "datetime TEXT");

    $name = htmlspecialchars($_POST['sign_up_name']);
    $email = htmlspecialchars($_POST['sign_up_email']);
    $password = htmlspecialchars($_POST['sign_up_password']);

    $main_conn->insert("records", array("Alex", "Popov", $datetime->format("D, d M Y H:i:s")));