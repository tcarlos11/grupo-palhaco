<?php
if(!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <div class='alert alert-danger mt-1' role='alert'>
            Você não está logado. <a href='index.php' class='btn-primary'>Entrar</a>
          </div>";
    die();
}
?>
