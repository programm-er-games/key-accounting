<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>Keys</title>
</head>

<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1></h1>
            <div class="input-group">
                <input type="search" placeholder="Найти...">
                <img src="images/user.png" alt="">
            </div>
            <div class="export__file">
                <a class="btn" href="../start_page/index.html">Вернуться</a>
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> ID </th>
                        <th> ФИО </th>
                        <th> Ключ </th>
                        <th> Выдача</th>
                        <th> Сдача </th>
                        <th> Статус </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require "../../db_v2.php";
                    $main_conn = new Db("C:\\Windows.old\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
                    $main_conn->start(["student_records" => [
                        "name" => "TEXT NOT NULL", "surname" => "TEXT NOT NULL", "patronymic" => "TEXT",
                        "key" => "TEXT NOT NULL UNIQUE", "time_in" => "TEXT NOT NULL",
                        "time_out" => "TEXT NOT NULL", "status" => "TEXT NOT NULL"
                    ]]);
                    $id = 0;
                    $status_list = [
                        "Выдан" => "status delivered",
                        "Отсутствует" => "status cancelled",
                        "У охраны" => "status shipped"
                    ];
                    $datetime = new DateTime(timezone: new DateTimeZone("+0300"));
                    // $main_conn->insert("student_records", [
                    //     "name" => "Alex", "surname" => "Pop", "key" => "0212843",
                    //     "time_in" => $datetime->format("h i s"), "time_out" => $datetime->format("h i s"), "status" => "Выдан"
                    // ]);
                    $data = $main_conn->get("student_records");
                    // var_dump($data);
                    foreach ($data as $row) {
                        $status = $status_list[$row["status"]];
                        echo
                        '
                        <tr>
                            <td>' . $id++ . '</td>
                            <td><img src="images/user.png" alt="">'
                             . $row["name"] . ' ' . $row["surname"] . ' ' . $row["patronymic"] . 
                            '</td>
                            <td>' . $row["key"] . '</td>
                            <td>' . $row["time_in"] . '</td>
                            <td>' . $row["time_out"] . '</td>
                            <td>
                                <p class="' . $status . '">' . $row["status"] . '</p>
                            </td>
                        </tr>
                        ';
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>