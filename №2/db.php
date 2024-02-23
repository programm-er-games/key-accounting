<?php
$datetime = new DateTime(timezone: new DateTimeZone("+0300"));
/*
    This is old version.
    Please use new (_v2) version for better experience
*/
class Db
{
    private $db;
    private $tables;


    function start(array $fill)
    {
        // var_dump($fill);
        $temp_tables = array_keys($fill);
        foreach ($temp_tables as $t) {
            // var_dump($fill[$t], in_array("datetime", array_keys($fill[$t])));
            if (!in_array("datetime", array_keys($fill[$t]))) $fill[$t]["datetime"] = "TEXT";
            // var_dump($fill[$t]);
        }
        $this->tables = $fill;
        // var_dump($this->tables);
        foreach ($this->tables as $table => $rows) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $table . "(";
            foreach ($rows as $row => $prop) {
                $sql .= $row . " " . $prop . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";
            $this->db->exec($sql);
        }
        // echo $sql;
        // var_dump($this->tables);
    }
    function insert(string $table, array $data)
    {
        global $datetime;
        // var_dump($this->tables);
        // var_dump($table, $data);
        $sql = "INSERT INTO " . $table;

        // var_dump($this->tables, $data);
        $tables_keys = array_keys($this->tables[$table]);
        $data_keys = array_keys($data);
        // var_dump($tables_keys, $data_keys);

        if (is_int($data_keys[0])) {
            $sql .= " VALUES (";
            // var_dump($tables_keys);
            array_push($data, $datetime->format("D, d M Y H:i:s"));
            for ($i = 0; $i < count($data); $i++) {
                $sql .= ":" . $tables_keys[$i] . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";
            // echo $sql;
            $sql = $this->db->prepare($sql);
            for ($i = 0; $i < count($data); $i++) {
                $sql->bindParam(":" . $tables_keys[$i], $data[$i]);
            }
            $sql->execute();
        } else {
            // var_dump(in_array("datetime", $data_keys));
            if (!in_array("datetime", $data_keys)) array_push($data_keys, "datetime");
            // var_dump($data_keys);
            $sql .= "(";
            for ($i = 0; $i < count($data_keys); $i++) {
                if (in_array($data_keys[$i], $tables_keys, true))
                    $sql .= $data_keys[$i] . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ") VALUES (";
            foreach ($data_keys as $value) {
                $sql .= ":" . $value . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";
            // echo $sql;
            // var_dump($data);
            $data["datetime"] = $datetime->format("D, d M Y H:i:s");
            // var_dump($data);
            $temp = array_keys($data);
            // var_dump($temp);
            $sql = $this->db->prepare($sql);
            for ($i = 0; $i < count($data); $i++) {
                // var_dump($data_keys[$i]);
                // var_dump($temp[$i]);
                // var_dump($data[$temp[$i]]);
                $sql->bindValue(":" . $data_keys[$i], $data[$temp[$i]]);
            }
            $sql->execute();
        }
    }
    function update(string $table, array $upd, array $cond)
    {
        // var_dump($upd, $cond);
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
        // var_dump($sql);
        foreach ($upd as $key => $value) {
            $sql->bindValue(":" . $key . "_upd", $value);
        }
        foreach ($cond as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }
        $sql->execute()->fetchArray(SQLITE3_ASSOC);
    }
    function delete(string $table, array $cond)
    {
        $sql = "DELETE FROM " . $table . " WHERE ";
        foreach ($cond as $key => $value) {
            $sql .= $key . " == :" . $key . " AND ";
        }
        $sql = substr($sql, 0, -5);
        // echo $sql;
        $sql = $this->db->prepare($sql);
        foreach ($cond as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }
        $sql->execute();
    }
    function get_where(string $table, array $cond)
    {
        $sql = "SELECT * FROM " . $table;
        if (count($cond) > 0) {
            $sql .= " WHERE ";
            foreach ($cond as $key => $value) {
                $sql .= $key . " == :" . $key . " AND ";
            }
            $sql = substr($sql, 0, -5);
            // echo $sql;
            $sql = $this->db->prepare($sql);
            foreach ($cond as $key => $value) {
                $sql->bindValue(":" . $key, $value);
            }
        }
        // var_dump($sql->execute()->fetchArray(SQLITE3_ASSOC));
        return $sql->execute()->fetchArray(SQLITE3_ASSOC);
    }
    function get_all(string $table, array $cond) {
        if (is_int(array_keys($cond)[0])) {
            $sql = "SELECT ";
            foreach ($cond as $value) {
                $sql .= $value . ", ";
            }
            $sql = str_ends_with($sql, ", ") ? substr($sql, 0, -2) : $sql;
            $sql .= " FROM " . $table;
            $sql = $this->db->prepare($sql);
            $sql->execute()->fetchArray(SQLITE3_ASSOC);
        }
        else {
            return "Ошибка! Неверно задан параметр ";
        }
    }
    function __construct(string $path)
    {
        $this->db = new SQLite3($path);
    }
    function __destruct()
    {
        $this->db->close();
    }
}
