<?php
include('protect.php');
include_once('conexao.php');

// Consulta ao banco de dados para obter os usuarios dos usuários
$sql_code = "SELECT usuario FROM usuarios";
$sql_query = $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

// Array para armazenar os usuarios dos usuários
$usuarios = array();

while ($row = $sql_query->fetch_assoc()) {
    $usuarios[] = $row['usuario'];
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Sua Página</title>
    <style>
        body {
      background-color: #004d00; /* Cor verde mais escuro */
    }
    .verdes{background-color: #25DBAE;

    }
    .label-custom2 {
  background: linear-gradient(to top, #003300, #006400); /* Degradê de verde escuro de cima para baixo */
  color: #fff; /* Cor do texto */
  padding: 10px; /* Ajuste conforme necessário */
  border-radius: 10px; /* Ajuste conforme necessário */
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

<div class="container mt-5">
    <h2 class="text-white text-center">Lista de Palhaços</h2>
    
    <!-- Lista de usuários de Usuários -->
<ul class="list-group label-custom2">
    <?php foreach ($usuarios as $usuario): ?>
        <li class="list-group-item label-custom2">
            <a href="perfilpalhaco.php?usuario=<?php echo urlencode($usuario); ?>"><h3 class="text-center"><?php echo $usuario; ?></h3></a>
        </li>
    <?php endforeach; ?>
</ul>

</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>