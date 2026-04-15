<?php
session_start();
require_once '../models/Usuario.php';
$acao = $_GET['acao'] ?? '';
if ($acao == 'login') {
    $usuario_form = $_POST['usuario'];
    $senha_form = $_POST['senha'];
    $usuarioModel = new Usuario();
    $user_id = $usuarioModel->autenticar($usuario_form, $senha_form);
    if ($user_id) {
        $_SESSION['usuario_logado'] = $user_id;
        header("Location: ../controllers/ProdutoController.php?acao=dashboard");
        exit;
    } else {
        echo "Login ou senha inválidos! <a href='../views/login.php'>Voltar</a>";
    }
} elseif ($acao == 'logout') {
    session_destroy();
    header("Location: ../views/login.php");
    exit;
}
?>