<?php
$main_conn = new SQLite3("C:\\Users\\User\\Documents\\GitHub\\key-accounting\\KA.db");
class Db {
    
    private $db;
    
    function insert(string $table, string $data) {
        $sql = "" . $table . "" . $data . "";
        $this->db->query($sql);
    }
    function __construct(string $path) { 
        $this->db = new SQLite3($path);
    }
}
?>