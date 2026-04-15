<?php
// Arquivo: config/database.php
class Database
{
    private $host = "localhost";
    private $db_name = "autopecas_db";
    private $username = "root"; // Usuário padrão do XAMPP
    private $password = "1234"; // Senha padrão do XAMPP (vazia)
    public $conn;
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>