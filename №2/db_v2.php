<?php
$datetime = new DateTime(timezone: new DateTimeZone("+0300"));
class Db
{
    private $db;
    private $tables;
    private $have_datetime;

    function start(array $fill, bool $with_datetime = true)
    {
        $temp_tables = array_keys($fill);
        foreach ($temp_tables as $t) {
            if (!in_array("datetime", array_keys($fill[$t])) && $with_datetime) $fill[$t]["datetime"] = "TEXT";
        }
        $this->have_datetime = $with_datetime ? true : false;
        $this->tables = $fill;
        foreach ($this->tables as $table => $rows) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $table . "(";
            foreach ($rows as $row => $prop) {
                $sql .= $row . " " . $prop . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";
            $this->db->beginTransaction();
            $this->db->query($sql);
            return $this->db->commit();
        }
    }
    function insert(string $table, array $data)
    {
        global $datetime;
        $this->db->beginTransaction();
        $sql = "INSERT INTO " . $table;
        $tables_keys = array_keys($this->tables[$table]);
        $data_keys = array_keys($data);
        if (is_int($data_keys[0])) {
            $sql .= " VALUES (";
            $this->have_datetime ? array_push($data, $datetime->format("D, d M Y H:i:s")) : null;
            for ($i = 0; $i < count($data); $i++) {
                if (str_contains($data[$tables_keys[$i]], "AUTOINCREMENT")) continue;
                $sql .= ":" . $tables_keys[$i] . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";
            $sql = $this->db->prepare($sql);
            for ($i = 0; $i < count($data); $i++) {
                if (str_contains($data[$tables_keys[$i]], "AUTOINCREMENT")) continue;
                $sql->bindParam(":" . $tables_keys[$i], $data[$i]);
            }
            $sql->execute();
        } else {
            if (!in_array("datetime", $data_keys) && $this->have_datetime) array_push($data_keys, "datetime");
            $sql .= "(";
            for ($i = 0; $i < count($data_keys); $i++) {
                if (str_contains($data[$tables_keys[$i]], "AUTOINCREMENT")) continue;
                if (in_array($data_keys[$i], $tables_keys, true))
                    $sql .= $data_keys[$i] . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ") VALUES (";
            foreach ($data_keys as $value) {
                if (str_contains($data[$tables_keys[$i]], "AUTOINCREMENT")) continue;
                $sql .= ":" . $value . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= ")";
            if ($this->have_datetime) $data["datetime"] = $datetime->format("D, d M Y H:i:s");
            $temp = array_keys($data);
            $sql = $this->db->prepare($sql);
            for ($i = 0; $i < count($data); $i++) {
                if (str_contains($data[$tables_keys[$i]], "AUTOINCREMENT")) continue;
                $sql->bindValue(":" . $data_keys[$i], $data[$temp[$i]]);
            }
            $sql->execute();
        }
        return $this->db->commit();
    }
    function update(string $table, array $upd, array $cond)
    {
        global $datetime;
        $this->db->beginTransaction();
        $sql = "UPDATE " . $table . " SET ";
        if ($this->have_datetime && !in_array("datetime", $upd)) {
            $upd["datetime"] = $datetime->format("D, d M Y H:i:s");
        }
        foreach ($upd as $key => $value) {
            $sql .= $key . " = :" . $key . "_upd, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE ";
        foreach ($cond as $key => $value) {
            $sql .= $key . " == :" . $key . " AND ";
        }
        $sql = substr($sql, 0, -5);
        $sql = $this->db->prepare($sql);
        foreach ($upd as $key => $value) {
            $sql->bindValue(":" . $key . "_upd", $value);
        }
        foreach ($cond as $key => $value) {
            $sql->bindValue(":" . $key, $value);
        }
        $sql->execute();
        return $this->db->commit();
    }
    function delete(string $table, array $cond = [])
    {
        $this->db->beginTransaction();
        if (count($cond) > 0) {
            $sql = "DELETE FROM " . $table . " WHERE ";
            foreach ($cond as $key => $value) {
                $sql .= $key . " == :" . $key . " AND ";
            }
            $sql = substr($sql, 0, -5);
            $sql = $this->db->prepare($sql);
            foreach ($cond as $key => $value) {
                $sql->bindValue(":" . $key, $value);
            }
            $sql->execute();
            return $this->db->commit();
        } else {
            $sql = "DELETE " . $table;
            $sql = $this->db->prepare($sql);
            $sql->execute();
            return $this->db->commit();
        }
    }
    function get(string $table, array $dst = [], array $cond = [])
    {
        $this->db->beginTransaction();
        $sql = "SELECT ";
        if (count($dst) > 0 && count($cond) > 0) {
            // echo "both != 0";
            foreach ($dst as $value) {
                $sql .= $value . ", ";
            }
            $sql = substr($sql, 0, -2);
            $sql .= " FROM " . $table . " WHERE ";
            foreach ($cond as $key => $value) {
                $sql .= $key . " == :" . $key . " AND ";
            }
            $sql = substr($sql, 0, -5);
            // echo $sql;
            $sql = $this->db->prepare($sql);
            foreach ($cond as $key => $value) {
                $sql->bindValue($key, $value);
            }
            $sql->execute();
            $result = $sql->fetchAll();
            $this->db->commit();
            return $result;
        } else if (count($dst) > 0) {
            // echo "dst != 0";
            if (is_int(array_keys($dst)[0])) {
                foreach ($dst as $value) {
                    $sql .= $value . ", ";
                }
                $sql = substr($sql, 0, -2);
                $sql .= " FROM " . $table;
                $sql = $this->db->prepare($sql);
                $sql->execute();
                $result = $sql->fetchAll();
                $this->db->commit();
                return $result;
            } else throw new Exception("Неверно задан второй параметр!", 1);
        } else if (count($cond) > 0) {
            // echo "cond != 0";
            $sql .= "* FROM " . $table . " WHERE ";
            foreach ($cond as $key => $value) {
                $sql .= $key . " == :" . $key . " AND ";
            }
            $sql = substr($sql, 0, -5);
            $sql = $this->db->prepare($sql);
            foreach ($cond as $key => $value) {
                $sql->bindValue($key, $value);
            }
            $sql->execute();
            $result = $sql->fetchAll();
            $this->db->commit();
            return $result;
        } else {
            // echo "both = 0";
            $sql .= "* FROM " . $table;
            $sql = $this->db->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll();
            $this->db->commit();
            return $result;
        }
    }
    function _get_tables()
    {
        return array_keys($this->tables);
    }
    function _get_rows(string $table = "")
    {
        if ($table) return array_keys($this->tables[$table]);
        else {
            $result = [];
            foreach (array_keys($this->tables) as $table) {
                $result[$table] = [];
                foreach (array_keys($this->tables[$table]) as $row) {
                    array_push($result[$table], $row);
                }
            }
            return $result;
        }
    }
    function _get_properties(string $table, string $row = "")
    {
        if ($row) return $this->tables[$table][$row];
        else return $this->tables[$table];
    }
    function __construct(string $path)
    {
        if (!$this->db = new PDO("sqlite:" . $path)) $this->db->errorInfo();
    }
}
