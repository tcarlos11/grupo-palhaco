<?php
include_once('conexao.php');

if(isset($_POST['usuario']) == 0) {
    echo "";
} else if(strlen($_POST['senha']) ==0) {
    echo "Preencha Sua Senha";
} else{
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $senha = $conn->real_escape_string($_POST['senha']);

    $sql_code = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
    $sql_query = $conn->query($sql_code) or die("Falha na exacução do Codigo SQL: " . $conn->error);

    $quantidade = $sql_query->num_rows;
    if($quantidade == 1) {
        $usuario = $sql_query->fetch_assoc();

        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['usuario'] = $usuario['usuario'];

        header("Location: sessao.php");
    }
    else {
        echo "Falha Ao logar Usuario ou Senha Incorreto";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login na Mente do Palhaco</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
      background-color: #004d00; /* Cor verde mais escuro */
    }
    .verdes{background-color: #25DBAE;

    }
    .label-custom {
    background: linear-gradient(to right, #006400, #003300); /* Degradê de verde escuro */
    color: #fff; /* Cor do texto */
    padding: 10px; /* Ajuste conforme necessário */
    border-radius: 5px; /* Ajuste conforme necessário */
  }
        </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light verdes">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="painelpalhaco.php">Painel <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-primary" href="index.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cadastropalhaco.php">Cadastro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sobre.php">Sobre</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Login do Palhaco</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="usuario" class="form-control label-custom" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" class="form-control label-custom" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="cadastropalhaco.php" class="btn btn-success mt-3">Cadastrar</a>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
 <!-- Rodapé -->
 <footer class="bg-dark text-light text-center py-3 fixed-bottom">
 <a href = "https://sites.google.com/view/tcarlos/in%C3%ADcio?authuser=0">PRTIFOLIO - TCARLOS</a>

        <p>&copy; 2023 TKSC</p>
    </footer>
</body>
</html>
