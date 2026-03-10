<?php
namespace App\Model;

use App\Database\Connection;
use PDO;

class Lista {
    public function listarTodas() {
        $sql = "SELECT * FROM tarefas ORDER BY id DESC";
        $stmt = Connection::getConn()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar($titulo) {
        $sql = "INSERT INTO tarefas (titulo) VALUES (?)";
        $stmt = Connection::getConn()->prepare($sql);
        return $stmt->execute([$titulo]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM tarefas WHERE id = ?";
        $stmt = Connection::getConn()->prepare($sql);
        return $stmt->execute([$id]);
    }
}