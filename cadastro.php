<?php
include('conexao.php');

$erro = '';
$sucesso = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $mysqli->real_escape_string($_POST["nome"]);
    $email = $mysqli->real_escape_string($_POST["email"]);
    $senha = $_POST["senha"];

    if (empty($nome)) {
        $erro = "Preencha seu nome.";
    } elseif (empty($email)) {
        $erro = "Preencha seu e-mail.";
    } elseif (empty($senha)) {
        $erro = "Preencha sua senha.";
    } else {
        // Verifica se o e-mail já está cadastrado
        $stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $erro = "E-mail já cadastrado. Por favor, use outro e-mail.";
        } else {
            // Insere o novo usuário no banco de dados
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nome, $email, $senha_hash);

            if ($stmt->execute()) {
                $sucesso = "Cadastro realizado com sucesso!";
            } else {
                $erro = "Falha ao cadastrar: " . $mysqli->error;
            }
        }

        $stmt->close();
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Crie a sua conta</h1>
    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>
    <?php if (!empty($sucesso)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($sucesso); ?></p>
    <?php endif; ?>
    <form action="cadastro.php" method="POST">
        <p>
            <label>Nome</label>
            <input type="text" name="nome" required>
        </p>
        <p>
            <label>E-mail</label>
            <input type="email" name="email" required>
        </p>
        <p>
            <label>Senha</label>
            <input type="password" name="senha" required>
        </p>
        <p>
            <button type="submit">Cadastrar</button>
        </p>
    </form>
    <p><a href="index.php">Já tem uma conta? Faça login</a></p>
</body>
</html>