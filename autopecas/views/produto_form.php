<!DOCTYPE html>
<html>

<head>
    <title>Formulário de Peça</title>
</head>

<body>
    <h2><?= isset($produto) ? 'Editar Peça' : 'Nova Peça' ?></h2>
    <form action="../controllers/ProdutoController.php?acao=salvar" method="POST">

        <input type="hidden" name="id" value="<?= $produto['id'] ?? '' ?>">

        <label>Código da Peça:</label><br>
        <input type="text" name="codigo_peca" value="<?= $produto['codigo_peca'] ??
            '' ?>" required><br><br>
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= $produto['nome'] ?? '' ?>" required><br><br>
        <label>Descrição:</label><br>
        <textarea name="descricao"><?= $produto['descricao'] ?? '' ?></textarea><br>
        <br>
        <label>Preço:</label><br>
        <input type="number" step="0.01" name="preco" value="<?= $produto['preco']
            ?? '' ?>" required><br><br>
        <label>Quantidade em Estoque:</label><br>
        <input type="number" name="quantidade_estoque" value="<?=
            $produto['quantidade_estoque'] ?? '' ?>" required><br><br>
        <button type="submit">Salvar Dados</button>
    </form>
    <br>
    <a href="../controllers/ProdutoController.php?acao=listar">Cancelar</a>
</body>

</html>