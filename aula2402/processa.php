<?php

// Importando o arquivo da classe
require_once 'escola/model/Aluno.php';

// Importando o namespace para facilitar o uso
use escola\model\Aluno;

// Verificando se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Capturando os dados do formulário
    $ra = (int)$_POST['ra'];
    $nome = $_POST['nome'];
    $turma = $_POST['turma'];
    $instituicao = $_POST['instituicao'];

    // Instanciando o objeto Aluno
    $aluno = new Aluno($ra, $nome, $turma, $instituicao);

    // Chamando o método matricular que retorna o array de dados
    $resultado = $aluno->matricular();

} else {
    // Redireciona de volta se tentarem acessar o arquivo diretamente
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Matrícula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Processamento de Matrícula</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title text-success"><?php echo $resultado['status']; ?></h5>
                <hr>
                <p><strong>RA:</strong> <?php echo $resultado['ra']; ?></p>
                <p><strong>Aluno:</strong> <?php echo $resultado['nome']; ?></p>
                <p><strong>Turma:</strong> <?php echo $resultado['turma']; ?></p>
                <p><strong>Instituição:</strong> <?php echo $resultado['instituicao']; ?></p>
                
                <a href="index.php" class="btn btn-primary mt-3">Voltar</a>
            </div>
        </div>
    </div>

</body>
</html>