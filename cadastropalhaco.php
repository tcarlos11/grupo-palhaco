<?php
include_once('conexao.php');

if(isset($_POST['cadastrar'])) {
    if(empty($_POST['usuario']) || empty($_POST['senha']) || empty($_POST['datanasci']) || empty($_POST['descricao']) || empty($_POST['pix']) || empty($_POST['genero']) ) {
        echo "Preencha todos os campos!";
    } else {
        $usuario = $conn->real_escape_string($_POST['usuario']);
        $senha = $conn->real_escape_string($_POST['senha']);
        $datanasci = $conn->real_escape_string($_POST['datanasci']);
        $descricao = $conn->real_escape_string($_POST['descricao']);
        $genero = $conn->real_escape_string($_POST['genero']);
        $pix = $conn->real_escape_string($_POST['pix']);

        $sql_code = "INSERT INTO usuarios (usuario, senha, datanasci, descricao, pix, genero) VALUES ('$usuario', '$senha', '$datanasci','$descricao', '$pix', '$genero')";
        $sql_query = $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

        if($sql_query) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
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
                <a class="nav-link" href="index.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn-success" href="cadastropalhaco.php">Cadastro</a>
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
            <h2 class="mb-4 text-white">Cadastro do Palhaço</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="usuario" class="text-white">Usuário</label>
                    <input type="text" class="form-control label-custom" id="usuario" name="usuario" required>
                </div>
                <div class="row">
    <div class="col">
        <div class="form-group">
            <label for="senha" class="text-white">Senha:</label>
            <input type="password" class="form-control col-12 label-custom" id="senha" name="senha" required>
        </div>
    </div>
    <div class="col offset-1">
        <div class="form-group">
            <label for="datanasci" class="text-white ">Data de Nascimento:</label>
            <input type="date" class="form-control col-8 label-custom text-white " id="datanasci" name="datanasci" required>
        </div>
    </div>
</div>


                <div class="form-group">
    <label for="descricao " class="text-white">Sua Descrição</label>
    <input type="text-white" class="form-control label-custom " id="descricao" name="descricao" required>
    <div class="form-group">
    <label for=pix class="text-white">Seu Pix: </label>
    <input type="text" class="form-control label-custom" id="pix" name="pix">
</div>
<div class="form-group label-custom">
        <label for="genero" >Gênero:</label>
        <select class="form-control" id="genero" name="genero">
            <option value="Masculino" >Masculino</option>
            <option value="Feminino">Feminino</option>
            <option value="Não binário">Não binário</option>
            <option value="Agênero">Agênero</option>
            <option value="Gênero fluido">Gênero fluido</option>
            <option value="Bigênero">Bigênero</option>
            <option value="Trigênero">Trigênero</option>
            <option value="Gustavo">Gustavo</option>
            <option value="Outro">Outro</option>
            <option value="Prefiro não dizer">Prefiro não dizer</option>
        </select>
    </div>
                <button type="submit" class="btn btn-success" name="cadastrar">Cadastrar</button>
                <a href="index.php" class="btn btn-primary mt-3">Faça o Login</a>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('cadastroForm').addEventListener('submit', function (event) {
        var usuario = document.getElementById('usuario').value;
        var senha = document.getElementById('senha').value;
        var descricao = document.getElementById('descricao').value;
        var genero = document.getElementById('genero').value;
        var datanasci = document.getElementById('datanasci').value;

        if (!usuario || !senha || !descricao || !genero || !datanasci) {
            alert('Preencha todos os campos!');
            event.preventDefault();
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
