<?php
session_start();

// Inicializa as variáveis para as mensagens
$msg = '';
$msg_type = ''; // Sucesso ou erro

// Verifica se o usuário está logado e se é admin ou escritor
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'escritor'])) {
    $msg = "Você precisa estar logado como escritor ou admin para adicionar notícias ou eventos.";
    $msg_type = 'danger'; // Define a cor do alerta como vermelho para erro
} else {
    require 'config.php';

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Coleta os dados do formulário
        $titulo = $_POST['titulo'];
        $conteudo = $_POST['conteudo'];
        $autor_id = $_SESSION['user_id']; // Obtém o ID do autor (usuário logado)

        // Processamento da imagem (se houver)
        $imagem = null; // Inicializa a variável imagem como nula

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            // Cria o diretório 'upload/' se não existir
            if (!is_dir('upload')) {
                mkdir('upload', 0777, true);
            }

            // Pega o nome original do arquivo
            $imagem_nome = basename($_FILES['imagem']['name']);
            // Define o caminho para salvar a imagem
            $imagem_destino = 'upload/' . $imagem_nome;

            // Move a imagem para o diretório 'upload/'
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_destino)) {
                $imagem = $imagem_destino;  // Salva o caminho da imagem no banco
            } else {
                $msg = "Erro ao fazer o upload da imagem.";
                $msg_type = 'danger';
            }
        }

        // Prepara a consulta para inserir a notícia ou evento
        $stmt = $conn->prepare("INSERT INTO noticias (titulo, conteudo, autor_id, imagem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $titulo, $conteudo, $autor_id, $imagem); // 's' para string, 'i' para inteiro

        // Executa a consulta e verifica se ocorreu sucesso
        if ($stmt->execute()) {
            $msg = "Notícia ou Evento salvo e aguardando confirmação.";
            $msg_type = 'success';
        } else {
            $msg = "Erro ao adicionar notícia ou evento: " . $stmt->error;
            $msg_type = 'danger';
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Adicionar Notícia ou Evento</title>
    <style>
        .alert-container {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            z-index: 9999;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mundo da Música - Escritor</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text mr-3">Bem-vindo, <?php echo $_SESSION['user']; ?>!</span>
                </li>
                <li class="nav-item ml-3">
                    <a class="btn btn-outline-danger" href="logout.php">Sair da conta</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container mt-4">
        <a href="index1.php" class="btn btn-secondary" style="position: absolute; top: 60px; left: 40px;">Voltar</a>
        <h2>Adicionar Notícia ou Evento</h2>
        <form action="addnew.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
                <label for="conteudo">Conteúdo</label>
                <textarea class="form-control" id="conteudo" name="conteudo" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="imagem">Imagem</label>
                <input type="file" class="form-control-file" id="imagem" name="imagem">
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>
    </div>

    <!-- Exibe a mensagem de sucesso ou erro (se houver) -->
    <?php if ($msg): ?>
    <div class="alert-container">
        <div class="alert alert-<?php echo $msg_type; ?>" role="alert">
            <?php echo $msg; ?>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
