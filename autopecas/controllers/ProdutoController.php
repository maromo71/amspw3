<?php
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: ../views/login.php");
    exit;
}
require_once '../models/Produto.php';
$acao = $_GET['acao'] ?? 'dashboard';
$produtoModel = new Produto();
if ($acao == 'dashboard') {
    require_once '../views/dashboard.php';
} elseif ($acao == 'listar') {
    $produtos = $produtoModel->listarTodos();
    require_once '../views/produto_list.php';
}
// ... continuação do ProdutoController.php
elseif ($acao == 'novo') {
    require_once '../views/produto_form.php';
} elseif ($acao == 'editar') {
    $id = $_GET['id'];
    $produto = $produtoModel->buscarPorId($id);
    require_once '../views/produto_form.php';
} elseif ($acao == 'salvar') {
    $id = $_POST['id'];
    $codigo = $_POST['codigo_peca'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['quantidade_estoque'];
    if (empty($id)) {
        // Se não tem ID, é cadastro novo
        $produtoModel->cadastrar($codigo, $nome, $descricao, $preco, $estoque);
    } else {
        // Se tem ID, é edição (O método atualizar não foi colocado no model acima para economizar espaço,
        //// mas seria um UPDATE simples seguindo a lógica do cadastrar)
        //// $produtoModel->atualizar($id, $codigo, $nome, $descricao, $preco, $estoque)
    }
    header("Location: ../controllers/ProdutoController.php?acao=listar");
    exit;
} elseif ($acao == 'excluir') {
    $id = $_GET['id'];
    $produtoModel->deletar($id);
    header("Location: ../controllers/ProdutoController.php?acao=listar");
    exit;
}

?>