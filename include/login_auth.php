<?php

session_start();
if (empty($_SESSION["login"]) && empty($_SESSION["senha"])) {
    $_SESSION["login"] = $_POST["login"];
    $_SESSION["senha"] = $_POST["senha"];
}

$login = $_SESSION["login"];
$senha = $_SESSION["senha"];


$servername = "localhost";
$username = "root";
$password = "lab2208";
$dbname = "controle_lab_eco_bd";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT senha, tipo, id FROM usuario WHERE login='$login'";
$result = $conn->query($sql);
$dados_usuario = $result->fetch_assoc();

if (empty($dados_usuario)) {
    $erro_login = "Usuário e/ou senha incorreto!";
    header("Location:index.php?erro_login=$erro_login");
} else {
    
    if (password_verify($senha, $dados_usuario["senha"])) {
        
        $_SESSION["tipo"] = $dados_usuario["tipo"];
        $_SESSION["id_usuario"] = $dados_usuario["id"];
        
    } else {
        $erro_login = "Usuário e/ou senha incorreto!";
        header("Location:index.php?erro_login=$erro_login");
    }
}

$conn->close();
?>