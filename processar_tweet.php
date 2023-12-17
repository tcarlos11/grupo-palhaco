<?php
include('protect.php');
include_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tweet']) && !empty($_POST['tweet'])) {
        $usuario_id = $_SESSION['id'];
        $tweet = $conn->real_escape_string($_POST['tweet']);

        $sql_code = "INSERT INTO posts (usuario_id, tweet) VALUES ('$usuario_id', '$tweet')";
        $conn->query($sql_code) or die("Falha na execução do Código SQL: " . $conn->error);

        // Redirecionar de volta para a página sessao.php após a inserção
        header("Location: sessao.php");
        exit();
    } else {
        echo "O campo de tweet não pode estar vazio.";
    }
}
?>
