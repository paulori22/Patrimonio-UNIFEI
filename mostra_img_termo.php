<?php

require 'include/login_auth.php';
require 'include/conexaoBD.php';

$id_emprestimo = ($_GET['id']);


$sql_img = "SELECT * FROM termo_responsabilidade WHERE id_emprestimo=$id_emprestimo";

$res = $conn->query($sql_img);


if ($res->num_rows > 0) {

    $row = $res->fetch_assoc();

    $img_emprestimo = $row['img_emprestimo'];
}

 //   header('Content-type: image/jpg');
 //    echo $img_emprestimo;
header("Content-Type: application/pdf");
header("Content-Length: ". strlen($img_emprestimo)); 
header('Content-Disposition: attachment; filename='."teste.pdf");
echo $img_emprestimo;