<?php
$host = "localhost"; 
$usuario = "root";
$senha = ""; 
$bancoDados = "bdpalhaco"; 


$conn = new mysqli($host, $usuario, $senha, $bancoDados);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

echo "Conexão Feita";


?>
