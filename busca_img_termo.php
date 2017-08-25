<?php

include_once('include/login_auth.php');
include_once 'header.php';
require 'include/conexaoBD.php';

$id_emprestimo = ($_GET['id']);


$sql_img = "SELECT * FROM termo_responsabilidade WHERE id_emprestimo=$id_emprestimo";

$res = $conn->query($sql_img);


if ($res->num_rows > 0) {

    $row = $res->fetch_assoc();

    $img_emprestimo = $row['img_emprestimo'];
}

if($img_emprestimo == NULL)
{
    echo '<div class="w3-container w3-center w3-red">Não há termo de responsabilidade no servidor</div>';
    
}
else{
    echo '<div class="w3-container w3-center">';
    echo '<img src="mostra_img_termo.php?id='.$id_emprestimo.'" class="w3-image" style="width:100%;max-width:1000px" />';
    echo '</div>';
}