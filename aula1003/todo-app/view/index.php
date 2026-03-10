<?php include 'header.php'; ?>

<div class="container">
    <h3 class="text-center">Suas Tarefas</h3>

    <form method="POST">
        <input class="form-control mb-2" type="text" name="titulo" placeholder="O que precisa ser feito?" required>
        <button class="btn btn-primary" type="submit" name="acao" value="cadastrar">Adicionar</button>
    </form>

    <ul class="list-group mt-1 mb-1 p-1 bg-dark text-white rounded">
        <?php if (empty($tarefas)): ?>
            <li class="list-group-item text-center">Nenhuma tarefa encontrada.</li>
        <?php else: ?>
            <?php foreach ($tarefas as $t): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($t['titulo']) ?></strong> 
                    [<?= $t['status'] ?>]
                    - <a class="btn btn-danger" href="?excluir=<?= $t['id'] ?>">Remover</a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>  
    

<?php include 'footer.php'; ?>