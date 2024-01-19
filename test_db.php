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
$test = new Db("C:\Users\User\Documents\GitHub\key-accounting\KA.db");
// $test->start("records", "name TEXT NOT NULL", "surname TEXT NOT NULL", "datetime TEXT");
$test->insert("records", array("Alex", "Popov", $datetime->format("D, d M Y H:i:s")));
$test->update("records", ["name" => "Alex"], ["name" => "Oleg"]);
$test->get("records", ["name" => "Alex", "surname" => "Popov"]);
$test->delete("records", ["surname"=> "Popov"]);
?>
</body>
</html>