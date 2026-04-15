### Projeto: Sistema de Gestão "Auto Peças do Baiano"

#### 1. Contextualização do Problema
No mercado atual, a informatização é fundamental para a sobrevivência e crescimento de qualquer negócio. O Sr. Baiano, proprietário da tradicional **"Auto Peças do Baiano"**, percebeu que o controle de seu estoque no caderno e em planilhas soltas estava gerando prejuízos. Peças sumiam, preços ficavam desatualizados e o atendimento ao cliente no balcão estava cada vez mais lento.

Para modernizar a loja, ele encomendou o desenvolvimento de um sistema web focado em gerenciar o seu catálogo de produtos. A aplicação precisa ser segura, permitindo o acesso apenas de funcionários autorizados, e deve oferecer operações completas de cadastro, leitura, atualização e exclusão (CRUD) das peças disponíveis no estoque.

#### 2. Objetivos de Aprendizagem do Laboratório
Este projeto prático não é apenas sobre entregar um software funcionando, mas sim sobre compreender as engrenagens por trás da web. Antes de migrarmos para ferramentas de mercado automatizadas, é essencial dominarmos a base. Ao longo das próximas aulas, o objetivo é construir essa aplicação do zero, aplicando os seguintes conceitos:

* **Arquitetura MVC Puro (Model, View, Controller):** Compreender a separação de responsabilidades na prática, sem depender de frameworks externos. Vocês entenderão como a requisição sai da tela, passa pelo controlador, busca a regra de negócio no modelo e retorna para o usuário.
* **Programação Orientada a Objetos com PHP:** Estruturar classes e métodos para lidar com a lógica de negócio e a conexão com o banco de dados.
* **Persistência e Segurança de Dados:** Criar a estrutura no MySQL, utilizar a interface PDO para prevenir Injeção de SQL e aplicar o conceito de hash para armazenamento seguro de senhas de acesso.

#### 3. Escopo e Metodologia
Para garantir o foco absoluto na lógica de backend, no fluxo de dados e na arquitetura do sistema, **não utilizaremos nenhuma estilização visual (CSS, Bootstrap ou templates externos)**. As interfaces (Views) serão construídas apenas com HTML puro.

O desenvolvimento será feito em servidor local (localhost) e as instruções a seguir guiarão vocês, passo a passo, na estruturação de todo o projeto.

---

### Passo 1: Estrutura de Diretórios
Criem uma pasta chamada `autopecas` no diretório raiz do servidor local (como o `htdocs` do XAMPP) ou em um diretório qualquer caso usem o servidor embutido do PHP. A organização será estritamente baseada no padrão MVC:

```text
autopecas/
│
├── config/
│   └── database.php        (Responsável pela conexão com o banco)
│
├── controllers/
│   ├── AuthController.php  (Gerencia login/logout)
│   └── ProdutoController.php (Gerencia o CRUD das peças)
│
├── models/
│   ├── Usuario.php         (Regras de negócio do usuário)
│   └── Produto.php         (Regras de negócio das peças)
│
├── views/
│   ├── login.php           (Formulário de acesso)
│   ├── dashboard.php       (Menu principal após logar)
│   ├── produto_form.php    (Formulário de cadastro/edição)
│   └── produto_list.php    (Tabela listando as peças)
│
└── index.php               (Front Controller - roteamento básico da aplicação)
```

---

### Passo 2: Banco de Dados (MySQL)
Este script deve ser executado no `phpMyAdmin`, `WorkBench` ou `DBeaver`. Ele cria o banco, as tabelas e já insere um usuário padrão para que vocês possam testar o login.

```sql
-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS autopecas_db;
USE autopecas_db;

-- Tabela de Usuários (Login)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Inserir um usuário administrador padrão (Senha: 123456)
-- Aqui usaremos uma hash simples MD5 para a senha '123456' para o primeiro teste.
INSERT INTO usuarios (usuario, senha) VALUES ('admin', MD5('123456'));

-- Tabela de Produtos (Autopeças)
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_peca VARCHAR(50) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    quantidade_estoque INT NOT NULL DEFAULT 0,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

> **Atenção sobre a Segurança:** Em produção, sempre usamos o `password_hash()` e `password_verify()` do PHP em vez do MD5. Mostraremos nos próximos passos como preparar a senha correta para o sistema.

---

### Passo 3: Criando os Códigos - Mão na Massa

Abaixo estão os códigos exatos de como cada arquivo deve ficar. Siga atentamente a criação de cada um nos seus respectivos diretórios e reproduza nos seus arquivos!

#### 3.1. Front Controller (Roteamento Básico)
**Arquivo:** `index.php` (na raiz da pasta `autopecas`)
Este arquivo é a "porta de entrada" da aplicação.

```php
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
```

#### 3.2. Configuração do Banco de Dados
**Arquivo:** `config/database.php`
Responsável pela conexão com o MySQL usando PDO.

```php
<?php
// Arquivo: config/database.php
class Database
{
    private $host = "localhost";
    private $db_name = "autopecas_db";
    private $username = "root"; // Usuário padrão do XAMPP
    private $password = "1234"; // Senha padrão do XAMPP (vazia)
    public $conn;
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erro na conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
```

#### 3.3. Models - Lógicas de Negócio
**Arquivo:** `models/Usuario.php`
Responsável por verificar credenciais no banco.

```php
<?php
require_once '../config/database.php';
class Usuario
{
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function autenticar($usuario, $senha_digitada)
    {
        $query = "SELECT id, senha FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Valida a senha em texto puro contra o hash do banco
            if (password_verify($senha_digitada, $row['senha'])) {
                return $row['id'];
            }
        }
        return false;
    }
}
?>
```

**Arquivo:** `models/Produto.php`
Comunicação da tabela `produtos` com a aplicação.

```php
<?php
require_once '../config/database.php';
class Produto
{
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function listarTodos()
    {
        $query = "SELECT * FROM produtos ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cadastrar($codigo, $nome, $descricao, $preco, $estoque)
    {
        $query = "INSERT INTO produtos (codigo_peca, nome, descricao, preco,
quantidade_estoque) VALUES (:codigo, :nome, :descricao, :preco, :estoque)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':estoque', $estoque);
        return $stmt->execute();
    }
    public function buscarPorId($id)
    {
        $query = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function deletar($id)
    {
        $query = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

}
?>
```

#### 3.4. Controllers - A Ponte entre Telas e Informação
**Arquivo:** `controllers/AuthController.php`
Controlador de autenticação e sessões.

```php
<?php
session_start();
require_once '../models/Usuario.php';
$acao = $_GET['acao'] ?? '';
if ($acao == 'login') {
    $usuario_form = $_POST['usuario'];
    $senha_form = $_POST['senha'];
    $usuarioModel = new Usuario();
    $user_id = $usuarioModel->autenticar($usuario_form, $senha_form);
    if ($user_id) {
        $_SESSION['usuario_logado'] = $user_id;
        header("Location: ../controllers/ProdutoController.php?acao=dashboard");
        exit;
    } else {
        echo "Login ou senha inválidos! <a href='../views/login.php'>Voltar</a>";
    }
} elseif ($acao == 'logout') {
    session_destroy();
    header("Location: ../views/login.php");
    exit;
}
?>
```

**Arquivo:** `controllers/ProdutoController.php`
Controlador geral para o estoque de produtos.

```php
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
```

#### 3.5. Views - A Interface do Usuário (HTML Puro)
**Arquivo:** `views/login.php`

```html
<!DOCTYPE html>
<html>

<head>
    <title>Login - Autopeças</title>
</head>

<body>
    <h2>Acesso ao Sistema</h2>
    <form action="../controllers/AuthController.php?acao=login" method="POST">
        <label>Usuário:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>

</html>
```

**Arquivo:** `views/dashboard.php`

```html
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <h2>Painel da Autopeças</h2>
    <p><a href="../controllers/ProdutoController.php?acao=listar">Listar
            Produtos</a></p>
    <p><a href="../controllers/ProdutoController.php?acao=novo">Cadastrar Novo
            Produto</a></p>
    <hr>
    <p><a href="../controllers/AuthController.php?acao=logout">Sair do Sistema</a>
    </p>
</body>

</html>
```

**Arquivo:** `views/produto_list.php`

```html
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
```

**Arquivo:** `views/produto_form.php`

```html
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
```

---

### Passo 4: Como Rodar a Aplicação

#### 4.1: Preparar o Banco de Dados
Lembre-se de rodar o SQL listado no Passo 2 e garanta que o banco de dados `autopecas_db` exista.

#### 4.2: O "Truque" da Senha Segura
Nosso sistema utiliza `password_verify()` para validar logins garantindo total proteção da senha no banco. A senha inserida no SQL do Passo 2 é um MD5 simples, o que **não funciona** com `password_verify` se não a transformarmos em uma Hash de senha moderna do PHP.

Para usar a senha original `123456`:
1. Crie temporariamente um arquivo `gerar_senha.php` na raiz do projeto contendo:
```php
<?php echo password_hash('123456', PASSWORD_DEFAULT); ?>
```
2. Abra este arquivo no seu navegador (ex: `http://localhost/autopecas/gerar_senha.php` no XAMPP ou rodando o embutido do PHP).
3. Copie o Hash (código extenso gerado na tela).
4. No phpMyAdmin ou software do seu banco, acesse a tabela `usuarios` no banco `autopecas_db` e altere o registro `admin`, colando o Hash no lugar do `md5` anterior.
5. Exclua o arquivo `gerar_senha.php` por questões de segurança.

#### 4.3: Iniciar o Projeto (Duas Alternativas)

**Alternativa A: Usando XAMPP**
1. Mova a pasta `autopecas` para dentro do `htdocs` do seu XAMPP.
2. Certifique-se que o serviço Apache e MySQL estejam rodando.
3. Acesse: `http://localhost/autopecas` no navegador e será levado para a tela de login via `index.php`.

**Alternativa B: Servidor Embutido do PHP (Recomendado na sala de aula)**
1. Abra o Terminal (Prompt de Comando, PowerShell ou Terminal do VSCode) e acesse a pasta `autopecas` (comando `cd caminho/para/autopecas`).
2. Digite o seguinte comando e dê enter:
   ```bash
   php -S localhost:8000
   ```
3. Abra seu navegador em: `http://localhost:8000`.

**Pronto!** Teste o login com o usuário `admin` e senha `123456`. Após entrar, teste todas as operações de cadastro, listagem e exclusão de peças do nosso sistema de gestão!