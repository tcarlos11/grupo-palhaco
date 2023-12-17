<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>SESSÃO DO PALHAÇO</title>
    <style>
        body {
            background-color: #004d00;
        }
        .verdes {
            background-color: #25DBAE;
        }
        .label-custom {
            background: linear-gradient(to top, #006400, #003300);
            color: #fff;
            padding: 10px;
            border-radius: 5px;
        }
        .label-custom2 {
            background: linear-gradient(to top, #003300, #006400);
            color: #fff;
            padding: 10px;
            border-radius: 10px;
        }
        H5 {
        
        }
        .custom-img {
            max-width: 200px; /* Defina o tamanho desejado */
            height: auto; /* Mantém a proporção da imagem */
            float: right;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light verdes">
    <div class="navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ">
            <li class="nav-item active">
                <a class="nav-link" href="sessao.php">INICIO <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sobre.php">SOBRE </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <!-- Coluna da Imagem -->
        <div class="col-md-4">
            <img src="JAE.PNG" alt="Imagem do Site" class="img-fluid custom-img">
        </div>

        <!-- Coluna da Descrição -->
        <div class="col-md-8">
            <h3 class = "m-2">SOBRE NOS</h3>
            <h5>
            Bem-vindo ao nosso site! Desenvolvido para fins de estudos, gostaríamos de receber a sua opinião sobre o que podemos adicionar ou se deseja relatar algum bug. Abaixo, há uma caixa de comentários. Sinta-se à vontade para compartilhar as suas observações. </h5>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2>Deixe seu comentário</h2>

    <!-- Formulário de Comentário -->
    <form method="post" action="submit_comment.php">
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="comment">Comentário:</label>
            <textarea class="form-control" id="comment" name="comment" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Comentário</button>
    </form>

    <!-- Lista de Comentários -->
    <div class="mt-4">
        <h3>Comentários</h3>
        <ul id="commentList" class="list-group">
            <!-- Comentários serão exibidos aqui dinamicamente -->
            <?php
            include_once('conexao.php');
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Se o formulário foi enviado, processar e salvar o comentário
                $name = $_POST['name'];
                $comment = $_POST['comment'];
                $sql = "INSERT INTO comments (name, comment) VALUES ('$name', '$comment')";
                $conn->query($sql);
            }

            // Exibir comentários
            $sql = "SELECT * FROM comments";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li class="list-group-item"><strong>' . $row['name'] . ':</strong> ' . $row['comment'] . '</li>';
                }
            } else {
                echo '<li class="list-group-item">Nenhum comentário ainda.</li>';
            }

            // Fechar a conexão
            $conn->close();

            ?>
        </ul>
    </div>
</div>

<footer class="bg-dark text-light text-center py-3 ">
    <a href="https://sites.google.com/view/tcarlos/in%C3%ADcio?authuser=0">PORTFÓLIO - TCARLOS</a>
    <p>&copy; 2023 TKMP</p>
</footer>

</body>
</html>
