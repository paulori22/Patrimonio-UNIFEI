<?php

if (!isset($_SESSION)) session_start();

switch ($_SESSION['tipo']) {
    case 1:
        include_once 'include/menu_adm.php';
     break;
    case 2:
        include_once 'include/menu_operador.php';
        break;
    case 3:
        include_once 'include/menu_standard.php';
        break;
    default:
      // Destrói a sessão por segurança
      session_destroy();
      // Redireciona o visitante de volta pro login
      header("Location: index.php"); exit;
        break;
}