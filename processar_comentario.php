<?php
include('protect.php');
include_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $comentario = $_POST['comentario'];
   
    // Insira o comentário no banco de dados
    $sql_code = "INSERT INTO comentarios (post_id, comentario, data_comentario) 
                  VALUES ('$post_id', '$comentario', NOW())";
    $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

    // Redirecione de volta para a página de sessão
    header("Location: sessao.php");
    exit();
} else {
    // Se o formulário não foi enviado via POST, redirecione para a página inicial
    header("Location: index.php");
    exit();
}
?>
