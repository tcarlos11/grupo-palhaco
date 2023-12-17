<?php
include('protect.php');
include_once('conexao.php');

// Verifica se o parâmetro 'usuario' está presente na URL
if (isset($_GET['usuario'])) {
    $perfil_usuario = urldecode($_GET['usuario']);

    // Consulta ao banco de dados para obter informações do perfil do usuário
    $sql_code = "SELECT * FROM usuarios WHERE usuario = '$perfil_usuario'";
    $sql_query = $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

    // Array para armazenar as informações do perfil do usuário
    $perfil_info = $sql_query->fetch_assoc();

    // Consulta ao banco de dados para obter as publicações do usuário selecionado
    $id_usuario = $perfil_info['id'];
    $sql_publicacoes = "SELECT tweet, data_publicacao FROM posts WHERE usuario_id = '$id_usuario' ORDER BY data_publicacao DESC";
    $query_publicacoes = $conn->query($sql_publicacoes) or die("Falha na execução do Código SQL: " . $conn->error);

    // Array para armazenar as publicações do usuário
    $publicacoes = array();

    while ($row = $query_publicacoes->fetch_assoc()) {
        $publicacoes[] = $row;
    }
} else {
    // Redireciona de volta à página inicial se o parâmetro 'usuario' não estiver presente
    header("Location: sessao.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Perfil de <?php echo $perfil_usuario; ?></title>
    <style>
        body {
      background-color: #004d00; /* Cor verde mais escuro */
    }
    .verdes{background-color: #25DBAE;

    }
    .label-custom {
    background: linear-gradient(to top, #006400, #003300); /* Degradê de verde escuro de baixo para cima */
    color: #fff; /* Cor do texto */
    padding: 10px; /* Ajuste conforme necessário */
    border-radius: 5px; /* Ajuste conforme necessário */
  }
        </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light verdes">
    <a class="navbar-brand" href="#">Bem Vindo, <?php echo $_SESSION['usuario']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="sessao.php">Início <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="usuarios.php">Palhaços </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sobre.php">Sobre</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="perfil.php">Perfil</a>
            </li>
            <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
        </ul>
    </div>
</nav>

<!-- Conteúdo da Página -->
<!-- Conteúdo da Página -->
<div class="container mt-5">
    <h2>Palhaço <?php echo $perfil_usuario; ?></h2>

    <?php if ($perfil_info): ?>
        <!-- Exibir informações do perfil do usuário -->
        <p>ID: <?php echo $perfil_info['id']; ?></p>
        <div class="mt-3 ">
            <h4 class="text-left font-weight-bold mt-3">Descrição:<p class="col-1 text-white ml-3"><em><?php echo $perfil_info['descricao']; ?></em></p></h4>
            
        </div>

        <!-- Informações adicionais do perfil -->
        <div class="perfil-info-container mt-3">
            <div class="d-inline-block">
                <h4 class="font-weight-bold">Gênero: <?php echo $perfil_info['genero']; ?></h4>
            </div>
            <div class="d-inline-block ml-3">
                <h4 class="text-left font-weight-bold">Pix Do Palhaço:</h4>
                <p class="text-white"><?php echo $perfil_info['pix']; ?></p>
            </div>
        </div>

        <!-- Espaço entre as informações do perfil e as publicações -->
        <hr class="mt-4 mb-4">

        <!-- Exibir as publicações do usuário -->
        <h3>Publicações</h3>
        <?php if (!empty($publicacoes)): ?>
            <ul class="list-group">
                <?php foreach ($publicacoes as $postagem): ?>
                    <li class="list-group-item label-custom">
                        <?php echo $postagem['tweet']; ?>
                        <small class="text-muted"><?php echo $postagem['data_publicacao']; ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nenhuma publicação encontrada.</p>
        <?php endif; ?>

    <?php else: ?>
        <p>Perfil não encontrado.</p>
    <?php endif; ?>
</div>



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
