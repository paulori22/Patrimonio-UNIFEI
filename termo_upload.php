<!DOCTYPE html>
<html>
    <title>Controle de Patrimonio ECO</title>

    <?php include_once('include/header_tabela.php'); ?>
    <?php include_once('include/login_auth.php'); ?>
    <?php require 'include/conexaoBD.php'; ?>
    <?php require 'include/controle_de_acesso_operador.php'; ?>

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
        $sql_inicio = "SELECT emprestimo.*, usuario.nome as nome_usuario,GROUP_CONCAT(patrimonio.numero_serie SEPARATOR ', ') as numero_serie "
                . "FROM `emprestimo` "
                . "	JOIN emprestimo_itens ON emprestimo.id_emprestimo = emprestimo_itens.id_emprestimo "
                . "	JOIN patrimonio ON emprestimo_itens.id_item = patrimonio.id "
                . "	JOIN usuario ON emprestimo.id_usuario = usuario.id "
                . "GROUP BY emprestimo.id_emprestimo;";
        $resultado = $conn->query($sql_inicio);
        ?>

        <?php include_once('menu.php'); ?>

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
                                <th>Usuário</th>
                                <th>Siape</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th>Data do Empréstimo</th>
                                <th>Pré Condições</th>
                                <th>Itens</th>
                                <th>Upload Termo</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Siape</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th>Data do Empréstimo</th>
                                <th>Pré Condições</th>
                                <th>Itens</th>
                                <th>Upload Termo</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if ($resultado->num_rows > 0) {
                                // output data of each row
                                while ($row = $resultado->fetch_assoc()) {
                                    $id = $row['id_emprestimo'];
                                    $nome_usuario = $row['nome_usuario'];
                                    $ra = $row['ra'];
                                    $nome = $row['nome'];
                                    $telefone = $row['telefone'];
                                    $email = $row['email'];
                                    $data_emprestimo = DateTime::createFromFormat ( "Y-m-d H:i:s", $row["data_emprestimo"] )->format('d/m/Y H:i:s');
                                    $pre_condicoes = $row['pre_condicoes'];
                                    $itens = $row['numero_serie'];

                                    echo "<tr>
            <td>$id</td>
            <td>$nome_usuario</td> 
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
                                        <a href="#edit<?php echo $id; ?>" data-toggle="modal"><button type='button' class='btn btn-success btn-sm'><span class='fa fa-upload' aria-hidden='true'></span></button></a>
                                        <a href="busca_img_termo.php?id=<?php echo $id; ?> " target="_BLANK" data-toggle="modal"><button type='button' class='btn btn-info btn-sm'><span class='fa fa-eye' aria-hidden='true'></span></button></a>
                                    </div>
                                </td>

                                <!--Upload Item Modal -->
                                <div id="edit<?php echo $id; ?>" class="modal fade" role="dialog">
                                    <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <div class="modal-dialog modal-lg">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Upload Termo de Responsabilidade</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_emprestimo" value="<?php echo $id; ?>">
                                                    <div class="form-group">
                                                        <label class="control-label">Escolha o arquivo (deve ser do tipo .jpg)</label>
                                                        <div class="w3-container">
                                                            <input id ="img_emprestimo" name="img_emprestimo" type="file" accept=".jpg" required>
                                                        </div>    
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="upload_termo"><span class="fa fa-pencil-square-o"></span> Enviar</button>
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                </form>


                                </tr>

                                <?php
                            }



                            //Enviar imagens
                            if (isset($_POST['upload_termo'])) {
                                $id_emprestimo = $_POST['id_emprestimo'];

                                // Make sure the user actually
                                // selected and uploaded a file

                                if (isset($_FILES['img_emprestimo']) && $_FILES['img_emprestimo']['size'] > 0) {


                                    // Temporary file name stored on the server

                                    $tmpName = $_FILES['img_emprestimo']['tmp_name'];


                                    // Read the file

                                    $fp = fopen($tmpName, 'r');

                                    $data_img = fread($fp, filesize($tmpName));

                                    $data_img = addslashes($data_img);

                                    fclose($fp);



                                    $sql_busca = "SELECT * FROM termo_responsabilidade WHERE id_emprestimo=$id_emprestimo";
                                    $res = $conn->query($sql_busca);

                                    if ($res->num_rows > 0) {
                                        $sql = "UPDATE termo_responsabilidade SET img_emprestimo='$data_img' ";

                                        if ($conn->query($sql) === TRUE) {
                                            echo "<script>alert('Termo sobreescrito. Upload efetuado com sucesso!');</script>";
                                        } else {
                                            echo "Erro ao realizar o upload do arquivo: " . $conn->error;
                                        }
                                    } else {
                                        $sql = "INSERT INTO termo_responsabilidade (id_emprestimo, img_emprestimo) VALUES ($id_emprestimo,'$data_img') ";

                                        if ($conn->query($sql) === TRUE) {
                                            echo "<script>alert('Upload efetuado com sucesso!');</script>";
                                        } else {
                                            echo "Erro ao realizar o upload do arquivo: " . $conn->error;
                                        }
                                    }
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
