<?php
// Arquivo: autopecas/index.php
session_start();

// MÁGICA DO ROTEAMENTO: Descobre o caminho base do projeto dinamicamente.
// No 'php -S' isso será vazio (""). No XAMPP será "/autopecas".
$base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

if (isset($_SESSION['usuario_logado'])) {
    // Redirecionamento Absoluto para o Dashboard
    header("Location: $base_path/controllers/ProdutoController.php?acao=dashboard");
    exit;
}

// Redirecionamento Absoluto para o Login
header("Location: $base_path/views/login.php");
exit;
?>