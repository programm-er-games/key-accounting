<?php
$datetime = new DateTime(timezone: new DateTimeZone("+0300"));
class Db {
    private $db;
    private $tables;

    function start(array $fill) {
        // for ($i = 0; $i < count($args); $i++) {
        //     $this->tables[$i] = $args[$i];
        // }
        // // var_dump($this->tables);
        // $sql = "CREATE TABLE IF NOT EXISTS " . $table . " (" . join(", ", $this->tables) . ")";
        // for ($i = 0; $i < count($args); $i++) {
        //     $temp = explode(" ", $this->tables[$i]);
        //     $this->tables[$i] = $temp[0];
        // }
        // // echo $sql."\n";
        // // var_dump($this->tables);
        // $this->db->exec($sql);
        foreach($fill as $table => $row) {
            $this->tables[$table] = $row;
        }
    }
    function insert(string $table, array $data) {
        global $datetime;
        $sql = "INSERT INTO " . $table . " VALUES (";
        foreach ($this->tables as $value) {
            $sql .= ":" . $value . ", ";
        }
        $sql = substr($sql, 0, -2);
        // echo $sql;
        $sql = $this->db->prepare($sql);
        // var_dump($data, $this->tables);
        array_push($data, $datetime->format("D, d M Y H:i:s"));
        for ($i = 0; $i < count($data); $i++) {
            $sql->bindParam(":" . $this->tables[$i], $data[$i]);
        }
        $sql->execute();
    }
    function update(string $table, array $upd, array $cond) {
        $sql = "UPDATE " . $table . " SET ";
        foreach ($upd as $key => $value) {
            $sql .= $key . " = :" . $key . "_upd, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE ";
        foreach ($cond as $key => $value) {
            $sql .= $key . " == :" . $key . " AND ";
        }
        $sql = substr($sql, 0, -5);
        // echo $sql;
        $sql = $this->db->prepare($sql);
        foreach ($upd as $key => $value) {
            $sql->bindValue(":" . $key . "_upd", $value);
        }
        foreach ($cond as $key => $value) {
            $sql->bindValue(":". $key, $value);
        }
        $sql->execute();
    }
    function delete(string $table, array $cond) {
        $sql = "DELETE FROM " . $table . " WHERE ";
        foreach ($cond as $key => $value) {
            $sql .= $key . " == :". $key . " AND ";
        }
        $sql = substr($sql, 0, -5);
        // echo $sql;
        $sql = $this->db->prepare($sql);
        foreach ($cond as $key => $value) {
            $sql->bindValue(":". $key, $value);
        }
        $sql->execute();
    }
    function get(string $table, array $cond) {
        $sql = "SELECT * FROM " . $table . " WHERE ";
        foreach ($cond as $key => $value) {
            $sql .= $key . " == :" . $key . " AND ";
        }
        $sql = substr($sql, 0, -5);
        // echo $sql;
        $sql = $this->db->prepare($sql);
        foreach ($cond as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }
        // var_dump($sql->execute()->fetchArray(SQLITE3_ASSOC));
        return $sql->execute()->fetchArray(SQLITE3_ASSOC);
    }
    function __construct(string $path) { 
        $this->db = new SQLite3($path);
    }
    function __destruct() {
        $this->db->close();
    }
}