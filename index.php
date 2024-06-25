<?php
include('conexao.php');
session_start();

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $mysqli->real_escape_string($_POST["email"]);
    $senha = $_POST["senha"];

    if (empty($email)) {
        $erro = "Preencha seu e-mail.";
    } elseif (empty($senha)) {
        $erro = "Preencha sua senha.";
    } else {
        $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        if ($sql_query->num_rows == 1) {
            $usuario = $sql_query->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION["id"] = $usuario["id"];
                $_SESSION["nome"] = $usuario["nome"];

                header("Location: painel.php");
                exit;
            } else {
                $erro = "Falha ao logar! E-mail ou senha incorretos.";
            }
        } else {
            $erro = "Falha ao logar! E-mail ou senha incorretos.";
        }
    }
}

// Verifica se há uma mensagem de erro na sessão
if (isset($_SESSION['mensagem_erro'])) {
    $erro = $_SESSION['mensagem_erro'];
    unset($_SESSION['mensagem_erro']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Acesse a sua conta</h1>
    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($erro); ?></p>
    <?php endif; ?>
    <form action="index.php" method="POST">
        <p>
            <label>E-mail</label>
            <input type="email" name="email" required>
        </p>
        <p>
            <label>Senha</label>
            <input type="password" name="senha" required>
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>
    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
</body>
</html>