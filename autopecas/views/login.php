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