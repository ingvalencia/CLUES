<?php
class Database {
    private $host = "localhost";
    private $db_name = "catalogo_clues";
    private $username = "root";
    private $password = "";
    public $conn;

    public function conectar() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die(json_encode(["error" => "Conexión fallida: " . $this->conn->connect_error]));
        }
        return $this->conn;
    }
}
?>
