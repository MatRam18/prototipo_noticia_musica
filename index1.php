<?php
session_start();

// Verifica se o usuário está logado e se o role dele é 'escritor'
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'escritor') {
    header('Location: login.php');
    exit();
}

require 'config.php';

// Consulta para pegar todas as notícias aprovadas
$result = $conn->query("SELECT * FROM noticias WHERE status = 'aprovado' ORDER BY data_criacao DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/principal.css">
    <title>Portal Para o Mundo da Música</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mundo da Música</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text mr-3">Bem-vindo, <?php echo $_SESSION['user']; ?>!</span>
                </li>
                <!-- Só exibe o botão de "Adicionar Notícias" para quem tem o role 'escritor' -->
                <?php if ($_SESSION['role'] === 'escritor'): ?>
                <li class="nav-item">
                    <a class="btn btn-outline-secondary" href="addnew.php">Adicionar Notícias</a>
                </li>
                <?php endif; ?>
                <li class="nav-item ml-3">
                    <a class="btn btn-outline-danger" href="logout.php">Sair da conta</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mt-4">
        <h1 class="mb-4">Notícias Aprovadas</h1>

        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="card">
                        <img src="<?php echo $row['imagem']; ?>" class="card-img-top" alt="Imagem da Notícia">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['titulo']; ?></h5>
                            <p class="card-text"><?php echo substr($row['conteudo'], 0, 150); ?>...</p>
                            <!-- Link para a página de exibição da notícia completa -->
                            <a href="exibir.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Leia mais</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 ETEC de Guarulhos. Todos os direitos reservados.</p>
    </footer>

    <!-- Scripts do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
