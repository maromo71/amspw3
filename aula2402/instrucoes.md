**AULA2402**.

---

# Documentação do Projeto: Sistema de Matrícula (PHP OO)

Esta documentação descreve a implementação de um sistema simples de matrícula escolar utilizando **Programação Orientada a Objetos (POO)** em PHP e **Bootstrap 5** para a interface.

## 1. Estrutura do Projeto

O projeto está organizado da seguinte forma:

```text
AULA2402/
├── escola/
│   └── model/
│       └── Aluno.php
├── index.php
└── processa.php

```

---

## 2. Camada de Modelo (`Aluno.php`)

Localizado em `escola/model/Aluno.php`, este arquivo define a lógica de negócio e o encapsulamento dos dados do aluno.

```php
<?php

namespace escola\model;

class Aluno {
    // Atributos privados (Encapsulamento)
    private int $ra;
    private string $nome;
    private string $turma;
    private string $instituicao;

    // Construtor para inicialização do objeto
    public function __construct(int $ra, string $nome, string $turma, string $instituicao) {
        $this->ra = $ra;
        $this->nome = $nome;
        $this->turma = $turma;
        $this->instituicao = $instituicao;
    }

    /**
     * Método matricular
     * Prepara os dados para serem exibidos ou processados
     */
    public function matricular(): array {
        return [
            'ra' => $this->ra,
            'nome' => $this->nome,
            'turma' => $this->turma,
            'instituicao' => $this->instituicao,
            'status' => 'Matrícula preparada com sucesso!'
        ];
    }
}

```

---

## 3. Interface de Usuário (`index.php`)

O arquivo principal utiliza Bootstrap 5 para criar um formulário de entrada de dados amigável.

```php
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
                                <label class="form-label">RA (Registro do Aluno)</label>
                                <input type="number" name="ra" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Turma</label>
                                <input type="text" name="turma" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Instituição</label>
                                <input type="text" name="instituicao" class="form-control" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">Matricular</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

```

---

## 4. Processamento de Dados (`processa.php`)

Este arquivo recebe os dados via `POST`, instancia a classe `Aluno` e exibe o resultado.

```php
<?php
require_once 'escola/model/Aluno.php';
use escola\model\Aluno;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $aluno = new Aluno(
        (int)$_POST['ra'],
        $_POST['nome'],
        $_POST['turma'],
        $_POST['instituicao']
    );

    $resultado = $aluno->matricular();
} else {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card border-success shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Matrícula Confirmada</h4>
            </div>
            <div class="card-body">
                <p><strong>Status:</strong> <?php echo $resultado['status']; ?></p>
                <hr>
                <p><strong>RA:</strong> <?php echo $resultado['ra']; ?></p>
                <p><strong>Nome:</strong> <?php echo $resultado['nome']; ?></p>
                <a href="index.php" class="btn btn-primary mt-3">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>

```

---

**Professor**, gostaria que eu adicionasse uma seção de "Desafios para o Aluno" ao final desta documentação para estimular a prática?