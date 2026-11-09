<?php
class Conexion {
    private string $host = "localhost";
    private string $db_name = "nexuslite_db";
    private string $username = "nexus_user";
    private string $password = "12345";
    public ?PDO $conn = null;

    public function obtenerConexion(): ?PDO {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>