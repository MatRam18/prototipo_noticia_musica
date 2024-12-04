<?php
session_start();

// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require 'config.php';

// Processamento de aprovação ou exclusão
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if ($_GET['action'] === 'aprovar') {
        // Atualiza o status da notícia para "aprovado"
        $stmt = $conn->prepare("UPDATE noticias SET status = 'aprovado' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($_GET['action'] === 'excluir') {
        // Exclui a notícia
        $stmt = $conn->prepare("DELETE FROM noticias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Recupera as notícias pendentes do banco de dados
$stmt = $conn->prepare("SELECT id, titulo, conteudo, imagem FROM noticias WHERE status = 'pendente'");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/requi.css">
    <title>Área de Requisições - Mundo da Música</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mundo da Música - Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text mr-3">Bem-vindo, <?php echo $_SESSION['user']; ?>!</span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-secondary" href="addnew1.php">Adicionar Notícias</a>
                </li>
                <li class="nav-item ml-3">
                    <a class="btn btn-outline-danger" href="logout.php">Sair da conta</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mt-4">
    <a href="index3.php" class="btn btn-secondary" style="position: absolute; top: 60px; left: 40px;">Voltar</a>
        <h2>Notícias Pendentes</h2>
        <div class="row">
            <?php
            // Exibe as notícias pendentes
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Caminho da imagem, se houver
                    $imagem = $row['imagem'] ? $row['imagem'] : 'images/default.jpg'; // Imagem padrão se não houver imagem

                    echo '<div class="col-md-6 mb-3">
                            <div class="card">
                                <!-- Título da notícia -->
                                <div class="card-header">
                                    <h5>' . $row['titulo'] . '</h5>
                                </div>
                                <!-- Imagem da notícia -->
                                <img src="' . $imagem . '" alt="Imagem da notícia" class="card-img-top">
                                <!-- Corpo da notícia -->
                                <div class="card-body">
                                    <p class="card-text">' . substr($row['conteudo'], 0, 150) . '...</p>
                                </div>
                                <!-- Rodapé com os botões -->
                                <div class="card-footer">
                                    <a href="requisicoes.php?action=aprovar&id=' . $row['id'] . '" class="btn btn-success">Aprovar</a>
                                    <a href="requisicoes.php?action=excluir&id=' . $row['id'] . '" class="btn btn-danger">Excluir</a>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo '<p>Não há notícias pendentes no momento.</p>';
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
