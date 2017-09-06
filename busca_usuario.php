<!DOCTYPE html>
<html>
    <title>Controle de Patrimonio ECO</title>
    
    <?php include_once('include/header_tabela.php');?>
    <?php include_once('include/login_auth.php');?>
    <?php require 'include/conexaoBD.php';?>
    <?php require 'include/controle_de_acesso_adm.php';?>
    
    <!--  Necessario para inciar a api DataTables     -->
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                
                
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
        
        $sql_inicio = "SELECT * FROM `usuario`";
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
                <br>

                <!-- Dados -->
            <div class="w3-container">

            <table id="example" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Senha</th>
                        <th>Tipo</th>
                        <th>Operações</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Senha</th>
                        <th>Tipo</th>
                        <th>Operações</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    if ($resultado->num_rows > 0) {
                        // output data of each row
                        while($row = $resultado->fetch_assoc()) {
                            $id = $row['id'];
                            $login = $row['login'];
                            $senha = $row['senha'];
                            $tipo = $row['tipo'];

                            echo "<tr>
            <td>$id</td>
            <td>$login</td>
            <td>$senha</td>
            <td>$tipo</td>
            ";
                    ?>
                    <td>
                        <div class='btn-group' role='group' aria-label='...'>
                            <a href="#edit<?php echo $id;?>" data-toggle="modal"><button type='button' class='btn btn-warning btn-sm'><span class='fa fa-pencil-square-o' aria-hidden='true'></span></button></a>
                            <a href="#delete<?php echo $id;?>" data-toggle="modal"><button type='button' class='btn btn-danger btn-sm'><span class='fa fa-trash-o' aria-hidden='true'></span></button></a>
                        </div>
                    </td>

        <!--Edit Item Modal -->
        <div id="edit<?php echo $id; ?>" class="modal fade" role="dialog">
            <form method="post" class="form-horizontal" role="form">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Editar Usuário</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="edit_usuario_id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="login">Login:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="login" name="login" value="<?php echo $login; ?>" placeholder="Login" required autofocus>
                                </div>
                                <label class="control-label col-sm-2" for="senha">Senha:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="senha" name="senha" value="<?php echo $senha; ?>" placeholder="Senha" required>
                                </div>
                                <label class="control-label col-sm-2" for="tipo">Tipo:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $tipo; ?>" placeholder="Tipo" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="update_usuario"><span class="fa fa-pencil-square-o"></span> Editar</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cancelar</button>
                        </div>
                    </div>
                </div>
        </div>
        </form>
        </div>

        <!--Delete Modal -->
        <div id="delete<?php echo $id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <form method="post">
                    <!-- Modal content-->
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Deletar Usuário</h4>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="delete_id" value="<?php echo $id; ?>">
                            <p>
                                <div class="alert alert-danger">Você tem certeza que deseja deletar <strong><?php echo $login; ?>?</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="delete" class="btn btn-danger"><span class="fa fa-trash-o"></span> Sim</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-times-circle"></span> Não</button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
        </tr>

        <?php
                        }

                        //Update Items
                        if(isset($_POST['update_usuario'])){
                            $edit_usuario_id = $_POST['edit_usuario_id'];
                            $login = $_POST['login'];
                            $senha= $_POST['senha'];
                            $tipo = $_POST['tipo'];
                            
                            $sql = "UPDATE usuario SET 
                                login='$login',
                                senha='$senha',
                                tipo='$tipo'
                                WHERE id=$edit_usuario_id ";
                            if ($conn->query($sql) === TRUE) {
                                echo '<script>window.location.href="busca_usuario.php"</script>';
                            } else {
                                echo "Erro ao atualizar registro: " . $conn->error;
                            }
                        }


                        if(isset($_POST['delete'])){
                            // sql to delete a record
                            $delete_id = $_POST['delete_id'];
                            $sql = "DELETE FROM usuario WHERE id='$delete_id' ";
                            if ($conn->query($sql) === TRUE) {
                      
                              echo '<script>window.location.href="busca_usuario.php"</script>';
                                
                            } else {
                                echo "Erro ao deletar o registro: " . $conn->error;
                            }
                        }
                    }
?>
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
   
                // Open and close the sidenav on medium and small screens
                function w3_open() {
                    document.getElementsByClassName("w3-sidenav")[0].style.display = "block";
                    document.getElementsByClassName("w3-overlay")[0].style.display = "block";
                }
                function w3_close() {
                    document.getElementsByClassName("w3-sidenav")[0].style.display = "none";
                    document.getElementsByClassName("w3-overlay")[0].style.display = "none";
                }

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
