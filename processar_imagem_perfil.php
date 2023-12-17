<?php
session_start();
include_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id'];
    $imagem_perfil = $_POST['imagem_perfil'];

    // Atualizar o campo da foto de perfil na tabela de usuários
    $sql_update_perfil = "UPDATE usuarios SET foto_perfil = '$imagem_perfil' WHERE id = '$id_usuario'";
    $conn->query($sql_update_perfil) or die("Falha na execução do Código SQL: " . $conn->error);

    // Redirecionar para evitar reenvio do formulário ao atualizar a página
    header("Location: perfil.php");
    exit();
}
?>
