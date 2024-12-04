<?php
require 'config.php';

session_start();

// Verifica se foi passado o ID da notícia via URL
if (!isset($_GET['id'])) {
    die('Notícia não encontrada.');
}

$id = $_GET['id'];

// Busca a notícia no banco de dados
$result = $conn->query("SELECT * FROM noticias WHERE id = $id");
if ($result->num_rows == 0) {
    die('Notícia não encontrada.');
}

$news = $result->fetch_assoc();

// Determina a URL de retorno com base no tipo de usuário logado
$redirectPage = 'index.php';
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == 'escritor') {
        $redirectPage = 'index1.php';
    } elseif ($_SESSION['user_type'] == 'admin') {
        $redirectPage = 'index3.php';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/exibir.css">
    <title>Exibir Notícia</title>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mundo da Música</a>
    </nav>

    <div class="container mt-4">
        <a href="<?php echo $redirectPage; ?>" class="btn btn-secondary" style="position: absolute; top: 60px; left: 40px;">Voltar</a>
        <div class="notice">
            
            <center>
                <h2><?php echo $news['titulo']; ?></h2>
                <img src="<?php echo $news['imagem']; ?>" class="img-not" alt="Imagem da Notícia">
            </center>
            
            <p class= "text"><?php echo nl2br($news['conteudo']); ?></p>
        </div>
        
    </div>

    <footer>
        <p>&copy; 2024 ETEC de Guarulhos. Todos os direitos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
