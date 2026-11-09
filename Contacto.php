<?php
require_once "Conexion.php";

class Contacto {
    private ?PDO $conn = null;
    private string $tabla = "formcontacto";

    public string $nombre = "";
    public string $correo = "";
    public string $telefono = "";
    public string $servicio = "";
    public string $mensaje = "";

    public function __construct() {
        $database = new Conexion();
        $this->conn = $database->obtenerConexion();
    }

    public function guardar(): bool {
        if ($this->conn === null) {
            return false;
        }

        $query = "INSERT INTO " . $this->tabla . " (nombre, correo, telefono, servicio, mensaje) VALUES (:nombre, :correo, :telefono, :servicio, :mensaje)";

        $stmt = $this->conn->prepare($query);

        $this->nombre   = htmlspecialchars(strip_tags($this->nombre));
        $this->correo   = htmlspecialchars(strip_tags($this->correo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->servicio = htmlspecialchars(strip_tags($this->servicio));
        $this->mensaje  = htmlspecialchars(strip_tags($this->mensaje));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":servicio", $this->servicio);
        $stmt->bindParam(":mensaje", $this->mensaje);

        return $stmt->execute();
    }
}
?>
