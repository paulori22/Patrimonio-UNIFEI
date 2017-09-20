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
        $sql_inicio = "SELECT emprestimo.*, usuario.nome as nome_usuario, GROUP_CONCAT(patrimonio.numero_serie SEPARATOR ', ') as numero_serie "
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
                                <th>Data do Empréstimo</th>
                                <th>Data da Devolução</th>
                                <th>Emprestado para</th>
                                <th>Itens</th>
                                <th>Pré Condições</th>
                                <th>Pós Condições</th>
                                <th>Siape</th>
                                <th>Telefone</th>
                                <th>E-mail</th>   
                                <th>Operador do sistema</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Data do Empréstimo</th>
                                <th>Data da Devolução</th>
                                <th>Emprestado para</th>
                                <th>Itens</th>
                                <th>Pré Condições</th>
                                <th>Pós Condições</th>
                                <th>Siape</th>
                                <th>Telefone</th>
                                <th>E-mail</th>   
                                <th>Operador do sistema</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if ($resultado->num_rows > 0) {
                                // output data of each row
                                while ($row = $resultado->fetch_assoc()) {
                                    $nome_usuario = $row['nome_usuario'];
                                    $ra = $row['ra'];
                                    $nome = $row['nome'];
                                    $telefone = $row['telefone'];
                                    $email = $row['email'];
                                    $data_emprestimo = DateTime::createFromFormat ( "Y-m-d H:i:s", $row["data_emprestimo"] )->format('d/m/Y H:i:s');                              
                                    
                                    if(is_null($row["data_devolucao"])){
                                        $data_devolucao = "Não Devolvido";
                                    }else{
                                        $data_devolucao = DateTime::createFromFormat ( "Y-m-d H:i:s", $row["data_devolucao"] )->format('d/m/Y H:i:s');
                                    }     
                                    $pre_condicoes = $row['pre_condicoes'];
                                    $pos_condicoes = $row['pos_condicoes'];
                                    $itens = $row['numero_serie'];

                                    echo "<tr>
            <td>$data_emprestimo</td>
            <td>$data_devolucao</td> 
            <td>$nome</td>
            <td>$itens</td>
            <td>$pre_condicoes</td>
            <td>$pos_condicoes</td>
            <td>$ra</td>
            <td>$telefone</td>
            <td>$email</td>
            <td>$nome_usuario</td>                
            ";
                                    ?>


                                </tr>

                                <?php
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
