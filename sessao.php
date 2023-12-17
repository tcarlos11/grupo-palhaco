<?php
include('protect.php');
include_once('conexao.php');

// Consulta ao banco de dados para obter os usuários
$sql_code = "SELECT usuario FROM usuarios";
$sql_query = $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

// Array para armazenar os usuários
$usuarios = array();

while ($row = $sql_query->fetch_assoc()) {
    $usuarios[] = $row['usuario'];
}

// Consulta ao banco de dados para obter as postagens
$sql_code = "SELECT posts.id, tweet, data_publicacao, usuarios.usuario
             FROM posts
             INNER JOIN usuarios ON posts.usuario_id = usuarios.id
             ORDER BY posts.data_publicacao DESC
             LIMIT 100"; // Limitando a 10 postagens, ajuste conforme necessário
$sql_query = $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

// Array para armazenar as postagens
$postagens = array();

while ($row = $sql_query->fetch_assoc()) {
    $postagens[] = $row;
}

// Extraindo os IDs das postagens para usar na consulta de comentários
$postIds = array_column($postagens, 'id');
$postIdsString = implode(',', $postIds);

// Consulta ao banco de dados para obter os comentários relacionados às postagens
$sql_code = "SELECT post_id, comentario, data_comentario
             FROM comentarios
             WHERE post_id IN ($postIdsString)
             ORDER BY data_comentario DESC";
$sql_query = $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

// Array associativo para armazenar os comentários, agrupados por postagem
$comentariosPorPostagem = array();

while ($row = $sql_query->fetch_assoc()) {
    $postId = $row['post_id'];
    $comentariosPorPostagem[$postId][] = $row;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>SESSÃO DO PALHAÇO</title>
    <style>
        body {
            background-color: #004d00; /* Cor verde mais escuro #004d00 */
        }
        .verdes {
            background-color: #25DBAE;
        }
        .label-custom {
            background: linear-gradient(to top, #006400, #003300); /* Degradê de verde escuro de baixo para cima */
            color: #fff; /* Cor do texto */
            padding: 10px; /* Ajuste conforme necessário */
            border-radius: 5px; /* Ajuste conforme necessário */
        }
        .label-custom2 {
            
            background: linear-gradient(to top, #003300, #006400); /* Degradê de verde escuro de cima para baixo */
            color: #fff; /* Cor do texto */
            padding: 10px; /* Ajuste conforme necessário */
            border-radius: 10px; /* Ajuste conforme necessário */
        }
        .imagembk{
            background-image: url('imagens_galeria/coringa01.png'); /* Substitua pelo caminho da sua imagem */
            padding: 10px; /* Ajuste conforme necessário */
            border-radius: 10px;
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
        .imagembk2{
            background-image: url('imagens_galeria/coringa02.png'); /* Substitua pelo caminho da sua imagem */
            padding: 10px; /* Ajuste conforme necessário */
            border-radius: 10px;
            background-size: cover;
            background-position: center;
            z-index: -1;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light verdes">
    <a class="navbar-brand" href="#">Bem Vindo, <?php echo $_SESSION['usuario']; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
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
                <a class="nav-link text-primary" href="perfil.php">Perfil</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-danger " href="logout.php">Sair</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h2 class="text-primary">O que está passando na mente do Palhaço?</h2>
    <form action="processar_tweet.php" method="post">
        <div class="form-group">
            <textarea class="form-control label-custom" name="tweet" rows="3" placeholder="Digite o que está passando na mente do Palhaço..." required></textarea>
        </div>
        <button type="submit" class="btn imagembk text-primary"><h4>CORINGAR</h4></button>
    </form>
</div>
<!-- Conteúdo da Página -->
<div class="container mt-5 bg-lighter">
    <h2 class="text-white">Últimas Coringadas</h2>
    <?php foreach ($postagens as $postagem): ?>
        <div class="card mb-3 label-custom">
            <div class="card-header">
                Publicado por <?php echo $postagem['usuario']; ?> em <?php echo $postagem['data_publicacao']; ?>
            </div>
            <div class="card-body">
                <p class="card-text"><?php echo $postagem['tweet']; ?></p>
            </div>

            <!-- Formulário de Comentário -->
            <div class="card-footer">
                <?php if (isset($postagem['id'])): ?>
                    <form action="processar_comentario.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $postagem['id']; ?>">
                        <div class="form-group">
                            <textarea class="form-control label-custom2 col-6" name="comentario" rows="1" placeholder="Comentário Anonimo..." required></textarea>
                        </div>
                        <button type="submit" title="Todas as Respostas São Anonimas"  class="imagembk2"><h4 >COMENTAR</h4></button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Exibir Comentários -->
            <div class="card-footer">
                <h5 class="text-white">Comentários</h5>
                
                <?php
                // Verificar se existem comentários para esta postagem
                if (isset($comentariosPorPostagem[$postagem['id']])) {
                    foreach ($comentariosPorPostagem[$postagem['id']] as $comentario) {
                        echo '<p>'.$comentario['comentario'].'</p>';
                    }
                    }

                ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
