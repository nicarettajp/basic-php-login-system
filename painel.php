<?php
include('protect.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Bem-vindo ao Painel Ubuild Gestão, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
    <p>
        <a href="logout.php">Sair</a>
    </p>
</body>
</html>