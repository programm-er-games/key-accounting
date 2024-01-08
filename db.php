<?php
$main_conn = new SQLite3("C:\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
class Db {
    private $db;
    private $arguments;

    function start(string $table, ...$args) {
        for ($i = 0; $i < count($args); $i++) {
            $this->arguments[$i] = $args[$i];
        }
        // var_dump($this->arguments);
        $sql = "CREATE TABLE IF NOT EXISTS " . $table . " (" . join(", ", $this->arguments) . ")";
        for ($i = 0; $i < count($args); $i++) {
            $temp = explode(" ", $this->arguments[$i]);
            $this->arguments[$i] = $temp[0];
        }
        // echo $sql."\n";
        // var_dump($this->arguments);
        $this->db->exec($sql);
    }
    function insert(string $table, array $data) {
        $sql = "INSERT INTO " . $table . " VALUES (";
        foreach ($this->arguments as $value) {
            $sql .= ":" . $value . ", ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ")";
        // echo $sql;
        $sql = $this->db->prepare($sql);
        // var_dump($data, $this->arguments);
        for ($i = 0; $i < count($data); $i++) {
            $sql->bindParam(":" . $this->arguments[$i], $data[$i]);
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
        var_dump($sql->execute()->fetchArray(SQLITE3_ASSOC));
    }
    function __construct(string $path) { 
        $this->db = new SQLite3($path);
    }
    function __destruct() {
        $this->db->close();
    }
}
?>