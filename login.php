<?php
session_start();
require 'config.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    // Prepara uma consulta para verificar se o login existe no banco de dados
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verifica se o usuário existe
    if ($resultado->num_rows > 0) {
        $user = $resultado->fetch_assoc();

        // Verifica se a senha é correta
        if ($senha === $user['senha']) {
            // Salva os dados do usuário na sessão
            $_SESSION['user_id'] = $user['idusuario']; // ID do usuário
            $_SESSION['user'] = $user['nome']; // Nome do usuário
            $_SESSION['role'] = $user['role']; // Função do usuário (admin e escritor)

            // Redireciona com base no papel do usuário
            if ($user['role'] === 'admin') {
                // Redireciona para o painel administrativo
                header('Location: index3.php');
                exit(); // Termina a execução após o redirecionamento
            } elseif ($user['role'] === 'escritor') {
                // Redireciona para a página do escritor
                header('Location: index1.php');
                exit();
            }
        } else {
            $erro = "Senha incorreta.";
        }
    } else {
        $erro = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
    <a href="index.php" class="btn btn-secondary" style="position: absolute; top: 10px; left: 40px;">Voltar</a>
    
    <form class="form" action="" method="POST">
        <div class="card">
            <div class="card-top">
                <h2 class="titulo">Painel de Login</h2>
                <p>Insira seus dados</p>
            </div>

            <!-- Exibição de erro, se houver -->
            <?php if (isset($erro)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <div class="card-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
            </div>
            <div class="card-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua Senha" required>
            </div>

            <a class="au" href="cadastro.php">Não tem conta? Cadastre-se aqui</a>
            <div class="card-group btn">
                <button type="submit" class="btn btn-primary">Acessar</button>
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
