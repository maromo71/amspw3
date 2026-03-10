<?php include 'header.php'; ?>

    <h2>Suas Tarefas</h2>

    <form method="POST">
        <input type="text" name="titulo" placeholder="O que precisa ser feito?" required>
        <button type="submit" name="acao" value="cadastrar">Adicionar</button>
    </form>

    <ul>
        <?php if (empty($tarefas)): ?>
            <li>Nenhuma tarefa encontrada.</li>
        <?php else: ?>
            <?php foreach ($tarefas as $t): ?>
                <li>
                    <strong><?= htmlspecialchars($t['titulo']) ?></strong> 
                    [<?= $t['status'] ?>]
                    - <a href="?excluir=<?= $t['id'] ?>">Remover</a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

<?php include 'footer.php'; ?>