<?php
// 1. Primeiro as configurações globais
require_once 'config.php';

// 2. Depois o autoloader das classes
require_once 'autoload.php';

use App\Model\Lista;

$listaModel = new Lista();

// Lógica de ações (POST/GET)
if (isset($_POST['acao'])) {
    if ($_POST['acao'] == 'cadastrar' && !empty($_POST['titulo'])) {
        $listaModel->salvar($_POST['titulo']);
    }
}

if (isset($_GET['excluir'])) {
    $listaModel->excluir($_GET['excluir']);
}

$tarefas = $listaModel->listarTodas();

// Carrega a View
include 'view/index.php';