<?php

session_start();
if (empty($_SESSION["id_usuario"]) && empty($_SESSION["senha"])) {
    $_SESSION["id_usuario"] = $_POST["id"];
    $_SESSION["senha"] = $_POST["senha"];
}

$id = $_SESSION["id_usuario"];
$senha = $_SESSION["senha"];
$servername = "localhost";
$username = "root";
$password = "lab2208";
$dbname = "controle_lab_eco_bd";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT senha FROM usuario WHERE id=$id";
$result = $conn->query($sql);
$dados_usuario = $result->fetch_assoc();

if (empty($dados_usuario)) {
    header("Location:index.php");
} else {
    $compara = strcmp($senha, $dados_usuario["senha"]);
    if ($compara == 0) {
        
    } else {
        header("Location:index.php");
    }
}

$conn->close();
?>