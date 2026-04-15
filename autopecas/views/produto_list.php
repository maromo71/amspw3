<!DOCTYPE html>
<html>

<head>
    <title>Lista de Peças</title>
</head>

<body>
    <h2>Peças em Estoque</h2>
    <a href="../controllers/ProdutoController.php?acao=dashboard">Voltar ao
        Dashboard</a>
    <br><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $p): ?>
            <tr>
                <td>
                    <?= $p['id'] ?>
                </td>
                <td>
                    <?= $p['codigo_peca'] ?>
                </td>
                <td>
                    <?= $p['nome'] ?>
                </td>
                <td>R$
                    <?= number_format($p['preco'], 2, ',', '.') ?>
                </td>
                <td>
                    <?= $p['quantidade_estoque'] ?>
                </td>
                <td>
                    <a href="../controllers/ProdutoController.php?acao=editar&id=<?=
                        $p['id'] ?>">Editar</a> |
                    <a href="../controllers/ProdutoController.php?acao=excluir&id=<?=
                        $p['id'] ?>" onclick="return confirm('Tem certeza?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>