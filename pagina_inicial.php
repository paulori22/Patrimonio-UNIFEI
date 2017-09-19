<?php

    require 'include/login_auth.php';
    require 'include/conexaoBD.php';
    
    if (!isset($_SESSION)) session_start();

switch ($_SESSION['tipo']) {
    case 1:
        header("Location: emprestimo.php");
     break;
    case 2:
        header("Location: emprestimo.php");
        break;
    case 3:
        header("Location: busca_permanente.php");
        break;
    default:
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: index.php"); exit;
        break;
}


