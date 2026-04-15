<?php
require_once '../config/database.php';
class Usuario
{
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function autenticar($usuario, $senha_digitada)
    {
        $query = "SELECT id, senha FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Valida a senha em texto puro contra o hash do banco
            if (password_verify($senha_digitada, $row['senha'])) {
                return $row['id'];
            }
        }
        return false;
    }
}
?>