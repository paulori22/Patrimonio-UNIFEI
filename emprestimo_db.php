<?php

include_once('include/login_auth.php');
require 'include/conexaoBD.php';


$ra = $_POST['ra'];
$id_usuario = $_SESSION["id_usuario"];
$id_itens = $_POST['id_values'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$pre_condicoes = $_POST['pre_condicoes'];
$observacao = $_POST['observacao'];


if (!($ra)) {
    print "O campo Siape deve ser preenchido, por favor verifique este campo";
    exit();
}

if (!($nome)) {
    print "O campo Nome deve ser preenchido, por favor verifique este campo";
    exit();
}

if (!($pre_condicoes)) {
    print "O campo Pré Condições deve ser preechido, por favor verifique este campo";
    exit();
}
if (!($id_itens)) {
    print "Não há itens selecionados para o emprestimo, por favor selecione os itens para o emprestimo";
    exit();
}

date_default_timezone_set('America/Sao_Paulo');
$data_emprestimo = date('Y/m/d H:i:s', time());

if(empty($observacao)){
$sql_insert = "INSERT INTO emprestimo (id_usuario, ra, nome, telefone, email, data_emprestimo, pre_condicoes)"
        . " VALUES ($id_usuario,'$ra', '$nome','$telefone','$email','$data_emprestimo','$pre_condicoes'); ";
}else{
    $sql_insert = "INSERT INTO emprestimo (id_usuario, ra, nome, telefone, email, data_emprestimo, pre_condicoes, observacao)"
        . " VALUES ($id_usuario,'$ra', '$nome','$telefone','$email','$data_emprestimo','$pre_condicoes','$observacao'); ";
}
if ($conn->query($sql_insert) === TRUE) {

    $id_emprestimo = $conn->insert_id;
    $id_itens_array = explode(',', $id_itens);
    $sql_emprestimo_itens = null;
    foreach ($id_itens_array as $id_item) {

        $sql_emprestimo_itens .= "INSERT INTO emprestimo_itens (id_emprestimo, id_item) VALUES ($id_emprestimo,$id_item);";
        $sql_emprestimo_itens .= "UPDATE patrimonio SET status=2 WHERE id=$id_item;";
    }
    if ($conn->multi_query($sql_emprestimo_itens) === TRUE) {
        print "Emprestimo inserido com sucesso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    $msg_emprestimo = "Erro ao inserir o emprestimo: " . $conn->error;
    print $msg_emprestimo;
    exit();
}
?>

