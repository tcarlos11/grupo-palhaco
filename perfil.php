<?php
include('protect.php');
include_once('conexao.php');

// ID do usuário autenticado
$id_usuario = $_SESSION['id'];

// Consulta ao banco de dados para obter informações do perfil do usuário autenticado
$sql_code = "SELECT * FROM usuarios WHERE id = '$id_usuario'";
$sql_query = $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

// Array para armazenar as informações do perfil do usuário autenticado
$perfil_info = $sql_query->fetch_assoc();

// Consulta ao banco de dados para obter as publicações do usuário autenticado
$sql_publicacoes = "SELECT id, tweet, data_publicacao FROM posts WHERE usuario_id = '$id_usuario' ORDER BY data_publicacao DESC";
$query_publicacoes = $conn->query($sql_publicacoes) or die("Falha na execução do Código SQL: " . $conn->error);

// Array para armazenar as publicações do usuário autenticado
$publicacoes = array();

while ($row = $query_publicacoes->fetch_assoc()) {
    $publicacoes[] = $row;
}

// Lógica para exclusão de postagens
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['excluir_postagem'])) {
        $postagem_id = $_POST['excluir_postagem'];
        $sql_excluir = "DELETE FROM posts WHERE id = '$postagem_id' AND usuario_id = '$id_usuario'";
        $conn->query($sql_excluir) or die("Falha na execução do Código SQL: " . $conn->error);

        // Redirecionar para evitar reenvio do formulário ao atualizar a página
        header("Location: perfil.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Meu Perfil</title>
    <style>
        body {
            background-color: #004d00; /* Cor verde mais escuro */
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

        .container {
            display: flex;
            justify-content: space-between;
            
        }

        .perfil-content {
            width: 70%; /* Largura do conteúdo do perfil */
        }

        .botoes-container {
            width: 25%; /* Largura dos botões */
            display: flex;
            align-items: center;
            padding: 10px; 
        }
        img{
            height: 120px;
            width: 120px;
            margin-top: -100px;
            margin-left:350;
        }
        .fotoperfi{
            margin-left:350;
            width: 120px;
            height: 50px;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light verdes">
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
                <a class="nav-link" href="#">Sobre</a>
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
<div class="container mt-3 border">
    <div class="perfil-content ml-3 p-3  ">
    <h2 class="font-weight-bold text-white ml-3 p-3">Mente do <?php echo $perfil_info['usuario']; ?></h2>
        <?php if ($perfil_info): ?>
            <!-- Exibir informações do perfil do usuário autenticado -->

            <div class="botoes-container ">
    <!-- Botão para editar perfil com popup -->
    <button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#editarPerfilModal"  title="Editar Perfil Da Mente">
        Editar Mente
    </button>

    <!-- Botão para abrir outro popup com nome de foto de perfil -->

    
        
        <div class="d-inline-block mt-3 p-3 ">
            <!-- Adicione aqui o código para exibir a foto de perfil -->
            <img src="JAE.PNG" alt="Foto de Perfil" class="img">
            <button  title="Editar Foto De Perfil" type="button" class="btn-secondary fotoperfi" data-toggle="modal" data-target="#fotoPerfilModal">
                    Foto de Perfil</button>
        </div>

        <!-- Exibir a descrição -->
        
</div>
<div class="mt-3  border-top">
            <h4 class="text-left font-weight-bold mt-3">Descrição:</h4>
            <p class="col-1 text-white ml-3"><?php echo $perfil_info['descricao']; ?></p>
        </div>
<div class="container">
    <div class="d-inline-block">
        <h4 class="font-weight-bold">Genero: </h4>
        <p class="text-white"><?php echo $perfil_info['genero']; ?></p>
    </div>
    <div class="d-inline-block">
        <h4 class="text-left font-weight-bold ">Pix Do Palhaço:</h4>
        <p class="text-white "><?php echo $perfil_info['pix']; ?></p>
    </div>
</div>
        <!-- Exibir as publicações do usuário autenticado -->

            <h3 class="label-custom text-center">Minhas Publicações</h3>

            <?php if (!empty($publicacoes)): ?>
                <ul class="list-group">
                    <?php foreach ($publicacoes as $postagem): ?>
                        <li class="list-group-item label-custom">
                            <?php echo $postagem['tweet']; ?>
                            <form method="post" action="">
                                <input type="hidden" name="excluir_postagem" value="<?php echo $postagem['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm float-right"  title="Excluir Publicação">Excluir</button>
                            </form>
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

    

</div>

<!-- Modal de Edição de Perfil -->
<div class="modal fade" id="editarPerfilModal" tabindex="-1" role="dialog" aria-labelledby="editarPerfilModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPerfilModalLabel">Editar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Foto de Perfil -->
<div class="modal fade" id="fotoPerfilModal" tabindex="-1" role="dialog" aria-labelledby="fotoPerfilModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fotoPerfilModalLabel">Foto de Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Adicione o campo de upload da nova foto de perfil aqui -->
                <!-- Exemplo: <input type="file" name="nova_foto" accept="image/*"> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Salvar Foto</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
