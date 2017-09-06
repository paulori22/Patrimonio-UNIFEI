<!DOCTYPE html>
<html>
    <title>Controle de Patrimonio ECO</title>
    
    <?php include_once('include/header_tabela.php');?>
    <?php include_once('include/login_auth.php');?>
    <?php require 'include/conexaoBD.php';?>
    <?php require 'include/controle_de_acesso_operador.php';?>

    <!--  Necessario para inciar a api DataTables     -->
    <script>
        $(document).ready(function () {
            var events = $('#events');
            var table = $('#example').DataTable( {
                
            responsive: true,
            colReorder: true,
            
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
                
            }
            

            });

     
    });

    </script>
     
    <body>
        <?php
        
        $sql_inicio =  "SELECT emprestimo.*,GROUP_CONCAT(patrimonio.numero_serie SEPARATOR ', ') as numero_serie "
    . "FROM `emprestimo` "
    . "	JOIN emprestimo_itens ON emprestimo.id_emprestimo = emprestimo_itens.id_emprestimo "
    . "	JOIN patrimonio ON emprestimo_itens.id_item = patrimonio.id "
    . "WHERE data_devolucao is NULL "
    . "GROUP BY emprestimo.id_emprestimo;";
        $resultado = $conn->query($sql_inicio);
 
        ?>
        
        <?php include_once('menu.php');?>

        <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer"></div>

        <div class="w3-main" style="margin-left:250px;">

            <div id="myTop" class="w3-top w3-container w3-padding-16 w3-indigo w3-large">
                <i class="fa fa-bars w3-opennav w3-hide-large w3-xlarge w3-margin-left w3-margin-right" onclick="w3_open()"></i>
                <span id="myIntro" class="w3-hide w3-indigo">Controle de Patrimônio ECO</span>
            </div>

            <header class="w3-container w3-indigo w3-padding-16" style="padding-left:32px">
                <h1 class="w3-xxxlarge w3-padding-16">Controle de Patrimonio ECO</h1>
            </header>

            <div class="w3-container w3-padding-32" style="padding-left:32px">

                <br>
                <?php
                if (@$_SESSION["cadastrado"] == 1) {
                    $_SESSION["cadastrado"] = 0;
                    ?>
                <?php }
                ?>
                
                <div id="resposta" class='w3-container w3-center w3-red'></div>
   
            
                <h2 style="text-align:center">Devolução</h2>
                
            <!-- Dados -->
            <div class="w3-container">

            <table id="example" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuário (ID)</th>
                        <th>RA/Siape</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Data do Empréstimo</th>
                        <th>Pré Condições</th>
                        <th>Itens</th>
                        <th>Devolver</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Usuário (ID)</th>
                        <th>RA/Siape</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Data do Empréstimo</th>
                        <th>Pré Condições</th>
                        <th>Itens</th>
                        <th>Devolver</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    if ($resultado->num_rows > 0) {
                        // output data of each row
                        while($row = $resultado->fetch_assoc()) {
                            $id = $row['id_emprestimo'];
                            $id_usuario = $row['id_usuario'];
                            $ra = $row['ra'];
                            $nome = $row['nome'];
                            $telefone = $row['telefone'];
                            $email = $row['email'];
                            $data_emprestimo = date('d/m/Y h:m:s', strtotime($row['data_emprestimo']));
                            $pre_condicoes= $row['pre_condicoes'];
                            $itens = $row['numero_serie'];
                            
                            

                            echo "<tr>
            <td>$id</td>
            <td>$id_usuario</td> 
            <td>$ra</td>
            <td>$nome</td>
            <td>$telefone</td>
            <td>$email</td>
            <td>$data_emprestimo</td>
            <td>$pre_condicoes</td>
            <td>$itens</td>
            ";
                    ?>
                    
                    <td>
                        <div class='btn-group' role='group' aria-label='...'>
                            <a href="#devolucao<?php echo $id;?>" data-toggle="modal"><button type='button' class='w3-button w3-teal'><span class='fa fa-check' aria-hidden='true'></span></button></a>
                        </div>
                    </td>

        <!--Devolução Modal -->
        <div id="devolucao<?php echo $id; ?>" class="modal fade" role="dialog">
            <form method="post" class="form-horizontal" role="form">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Devolução</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_emprestimo" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="login">Pós Condições:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="pos_condicoes" name="pos_condicoes"  placeholder="Pós condições" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="devolucao"><span class="fa fa-pencil-square-o"></span> Confirmar devolução</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cancelar</button>
                        </div>
                    </div>
                </div>
        </div>
        </form>
        </div>
            
        </tr>

        <?php
                        }

                        //Realizar devolução
                        if(isset($_POST['devolucao'])){
                            $id_emprestimo = $_POST['id_emprestimo'];
                            $pos_condicoes = $_POST['pos_condicoes'];
                            
                            date_default_timezone_set('America/Sao_Paulo');
                            $data_devolucao = date('Y/m/d H:i:s', time());
                            
                            $itens_emprestimo = "SELECT * FROM `emprestimo_itens` WHERE id_emprestimo=$id_emprestimo;";
                            
                            $resultado_itens_emprestimo = $conn->query($itens_emprestimo);
                            
                            $sql_devolucao = NULL;
                            
                            if ($resultado_itens_emprestimo->num_rows > 0) {
                                // output data of each row
                                while($row = $resultado_itens_emprestimo->fetch_assoc()) {
                                
                                    $id_item = $row['id_item'];
   
                                    $sql_devolucao .= "UPDATE patrimonio SET status=1 WHERE id=$id_item;";
                                
                                }
   

                            $sql_devolucao .= "UPDATE emprestimo SET 
                                pos_condicoes='$pos_condicoes',
                                data_devolucao='$data_devolucao'
                                WHERE id_emprestimo=$id_emprestimo ";
                            
                            if ($conn->multi_query($sql_devolucao) === TRUE) {
                                
                                echo "<script>alert('Devolução cadastrada com sucesso!');window.location.href = 'devolucao.php';</script>";
                            } else {
                                echo "Erro ao realizar a devolução: " . $conn->error;
                            }
                        }

                    }
               }
        
?>

        </tr>

            </tbody>
            </table>
            </div>
                         
            <br><br>
                

                <footer class="w3-container w3-indigo w3-padding-32" style="padding-left:32px">
                    <p>Copyright - Engenharia da Computação</p>  
                    <p>Universidade Federal de Itajuba - campus Itabira</p>
                </footer>

            </div>
            

            <script>

                // Change style of top container on scroll
                window.onscroll = function () {
                    myFunction()
                };
                function myFunction() {
                    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
                        document.getElementById("myTop").classList.add("w3-card-4");
                        document.getElementById("myIntro").classList.add("w3-show-inline-block");
                    } else {
                        document.getElementById("myIntro").classList.remove("w3-show-inline-block");
                        document.getElementById("myTop").classList.remove("w3-card-4");
                    }
                }

                // Accordions
                function myAccordion(id) {
                    var x = document.getElementById(id);
                    if (x.className.indexOf("w3-show") == -1) {
                        x.className += " w3-show";
                        x.previousElementSibling.className += " w3-theme";
                    } else {
                        x.className = x.className.replace("w3-show", "");
                        x.previousElementSibling.className =
                                x.previousElementSibling.className.replace(" w3-theme", "");
                    }
                }

            </script>

    </body>
</html> 
