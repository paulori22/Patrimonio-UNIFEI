<!DOCTYPE html>
<html>
    <title>Controle de Patrimonio ECO</title>
    
    <?php include_once('include/header_tabela.php');?>
    <?php include_once('include/login_auth.php');?>
    <?php require 'include/conexaoBD.php';?>
    
    <?php $msg_emprestimo = NULL; ?>

    <!--  Necessario para inciar a api DataTables     -->
    <script>
        $(document).ready(function () {
            var events = $('#events');
            var table = $('#example').DataTable( { 
                
            responsive: true,
            colReorder: true,

            select: {
                style: 'multi'
            },
            
            
            
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json",
                select: {
                    rows: {
                        _: "%d registros selecionados",
                        1: "1 registro selecionado"
                    }
                }
            }
            

            });
            
      
      
       $('#botao_emprestimo').click(function () {
        var ids = $.map(table.rows('.selected').data(), function (item) {
            return item[0]
        });
        var data_array = $("#cadastrar_emprestimo").serialize() + '&id_values=' + ids;
        $.ajax({
            type: "POST",
            url: "emprestimo_db.php",
            //type: "JSON",
            data: data_array,
            success: function(data) {
                
                 confirm(data);
                 $("#resposta").html(data);
                 if(data=="Emprestimo inserido com sucesso!"){
                 window.location.reload();}
            }
        });
    });
    


    } );
    


    </script>
     
    <body>
        <?php
        
        $sql_inicio = "SELECT * FROM `patrimonio` WHERE status!=2";
        $resultado = $conn->query($sql_inicio);
 
        ?>
        
        <?php include_once('menu.php');?>

        <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer"></div>

        <div class="w3-main" style="margin-left:250px;">

            <div id="myTop" class="w3-top w3-container w3-padding-16 w3-indigo w3-large">
                <span class="fa fa-bars w3-opennav w3-hide-large w3-xlarge w3-margin-left w3-margin-right" onclick="w3_open()"></span>
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
   
            
                <h2 style="text-align:center">Empréstimo</h2>
                <form id="cadastrar_emprestimo" class="w3-container" action="emprestimo.php">
                    <div class="w3-section">
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="RA ou Siape" name="ra" required>
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Nome" name="nome" required>         
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Telefone" name="telefone">
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Email" name="email">
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Pré Condições" name="pre_condicoes" required>
                        </div>
            <!-- Dados -->
            <div class="w3-container">

            <table id="example" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número de Série</th>
                        <th>Descrição/Fabricante/Modelo</th>
                        <th>Localização</th>
                        <th>Locação</th>
                        <th>Status</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Número de Série</th>
                        <th>Descrição/Fabricante/Modelo</th>
                        <th>Localização</th>
                        <th>Locação</th>
                        <th>Status</th>
                        <th>Observação</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    if ($resultado->num_rows > 0) {
                        // output data of each row
                        while($row = $resultado->fetch_assoc()) {
                            $id = $row['id'];
                            $numero_serie = $row['numero_serie'];
                            $descricao_fabricante_modelo = $row['descricao_fabricante_modelo'];
                            $localizacao = $row['localizacao'];
                            $locacao = $row['locacao'];
                            $status = $row['status'];
                            $observacao = $row['observacao'];
                            
                            switch ($status) {
                            case 0:
                                $status_string = "Ocioso";
                                break;
                            case 1:
                                $status_string =  "Ativo (em uso)";
                                break;
                            case 2:
                                $status_string =  "Emprestado";
                                break;
                            case 3:
                                $status_string = "Interditado";
                                break;
                            default :
                                $status_string = "Sem status definido";
                                break;
                            }

                            echo "<tr>
            <td>$id</td>
            <td>$numero_serie</td> 
            <td>$descricao_fabricante_modelo</td>
            <td>$localizacao</td>
            <td>$locacao</td>
            <td>$status_string</td>
            <td>$observacao</td>
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
                
            <button id="botao_emprestimo" type="button" class="w3-btn-block w3-section w3-padding button button1" >Realizar o empréstimo</button>
            </form>      
            
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
