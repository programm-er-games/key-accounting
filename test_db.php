<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>
<body>
<?php
$datetime = new DateTime(timezone: new DateTimeZone("+0300"));
// echo $datetime->format(DATE_RSS);
require "№2/db.php";
$test = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");

$test->start(["student_records" => ["name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "datetime" => "TEXT"],
            "security" => ["name" => "TEXT NOT NULL UNIQUE", "surname" => "TEXT NOT NULL UNIQUE", "phone" => "TEXT NOT NULL UNIQUE", "password" => "TEXT NOT NULL UNIQUE"]]);
$test->insert("security", ["Alexey", "Popov", "+12345678910", "qpwoe12"]);
// $test->insert("student_records", ["name" => "Alex", "surname" => "Pop"]);

// $test->update("student_records", ["name" => "Alex"], ["name" => "Oleg"]);
// var_dump($test->get("student_records", ["name" => "Alex", "surname" => "Pop"]));
// $test->delete"student_records", ["surname"=> "Popov"]);
?>
</body>
</html>