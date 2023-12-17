<?php
include_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos 'name' e 'comment' estão definidos
    if (isset($_POST['name']) && isset($_POST['comment'])) {
        $name = $_POST['name'];
        $comment = $_POST['comment'];

        // Insere os dados no banco de dados
        $sql = "INSERT INTO comments (name, comment) VALUES ('$name', '$comment')";

        if ($conn->query($sql) === TRUE) {
            // Redireciona de volta à página principal após o envio do comentário
            header("Location: sessao.php");
            exit();
        } else {
            // Em caso de erro, exibe uma mensagem
            echo "Erro ao enviar o comentário: " . $conn->error;
        }
    } else {
        // Exibe uma mensagem se os campos não estiverem definidos
        echo "Campos 'name' e 'comment' não estão definidos.";
    }
} else {
    // Se o método da requisição não for POST, redireciona à página principal
    header("Location: sessao.php");
    exit();
}

// Fecha a conexão
$conn->close();
?>
