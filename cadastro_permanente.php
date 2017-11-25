<!DOCTYPE html>
<html>
    <title>Controle de Patrimonio ECO</title>
    
    <?php include_once('header.php');?>
    <?php require 'include/login_auth.php';?>
    <?php require 'include/conexaoBD.php';?>
    <?php require 'include/controle_de_acesso_adm.php';?>
    
    <body>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //something posted

            $numero_serie = mysqli_real_escape_string($conn,$_REQUEST['numero_serie']);
            
            $descricao_fabricante_modelo = mysqli_real_escape_string($conn,$_REQUEST['descricao_fabricante_modelo']);
            
            $localizacao = mysqli_real_escape_string($conn, $_REQUEST['localizacao']);
            
            $locacao = mysqli_real_escape_string($conn, $_REQUEST['locacao']);
            
            $status = $_REQUEST['status'];
            
            //$tag_patrimonio = mysqli_real_escape_string($conn, $_REQUEST['tag_patrimonio']);

            $observacao = mysqli_real_escape_string($conn, $_REQUEST['observacao']);


            // attempt insert query execution
            $sql = "INSERT INTO patrimonio (numero_serie, descricao_fabricante_modelo, localizacao, locacao, status, observacao) VALUES ('$numero_serie', '$descricao_fabricante_modelo', '$localizacao','$locacao', $status,'$observacao')";

            if ($conn->query($sql) === TRUE) {
                $cadastro_sucesso = "Cadastro realizado com sucesso!";
            } else {
                $cadastro_error = "Algo de errado aconteceu com o cadastro: ".$conn->error;
            }


        }
        
        

        $conn->close();
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
                
                <?php
                      if (isset($cadastro_sucesso)) {
                      echo "<div class='w3-container w3-center w3-green'>";
                      echo $cadastro_sucesso;
                      echo "</div>";
                      }elseif(isset($cadastro_error)){
                          echo "<div class='w3-container w3-center w3-red'>";
                          echo $cadastro_error;
                          echo "</div>";
                      }

                ?>
                <h2 style="text-align:center">Cadastro Permanente</h2>
                <form class="w3-container" action="cadastro_permanente.php" method="post">
                    <div class="w3-section">
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Número de serie" name="numero_serie" required>
                        
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Descrição/Fabricante/Modelo" name="descricao_fabricante_modelo" required>
                        
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Localização" name="localizacao" required>
                        
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Locação" name="locacao" required>
                        
                        <select class="w3-select w3-border w3-margin-bottom" name="status" required>
                            <option value="" disabled selected>Escolha o status do patrimônio</option>
                            <option value="1">Ativo (em uso)</option>
                            <option value="0">Ocioso</option>
                            <option value="3">Interditado</option>
                        </select>

                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Observação" name="observacao" required>
                        
                        <button class="w3-btn-block w3-section w3-padding button button1" type="submit">Cadastrar</button>
                    </div>
                </form>

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

            </script>

    </body>
</html> 
