<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrícula de Aluno - AULA2402</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Cadastro de Matrícula</h4>
                    </div>
                    <div class="card-body">
                        <form action="processa.php" method="POST">
                            
                            <div class="mb-3">
                                <label for="ra" class="form-label">RA (Registro do Aluno)</label>
                                <input type="number" name="ra" id="ra" class="form-control" placeholder="Ex: 123456" required>
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite o nome do aluno" required>
                            </div>

                            <div class="mb-3">
                                <label for="turma" class="form-label">Turma</label>
                                <input type="text" name="turma" id="turma" class="form-control" placeholder="Ex: 3º DSM" required>
                            </div>

                            <div class="mb-3">
                                <label for="instituicao" class="form-label">Instituição</label>
                                <input type="text" name="instituicao" id="instituicao" class="form-control" placeholder="Ex: Fatec Mogi Mirim" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">Matricular</button>
                            </div>

                        </form>
                    </div>
                </div>
                <p class="text-center mt-3 text-muted small">Projeto: AULA2402 - Prof. Maromo</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>