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
            
            $login = mysqli_real_escape_string($conn,$_REQUEST['login']);

            $tipo = $_REQUEST['tipo'];

            $senha = mysqli_real_escape_string($conn, $_REQUEST['senha']);

            // attempt insert query execution
            $sql = "INSERT INTO usuario (login, tipo, senha) VALUES ('$login', $tipo, '$senha')";

            if ($conn->query($sql) === TRUE) {
                $cadastro_sucesso = "Cadastro realizado com sucesso!";
            } else {
                $cadastro_error = "Algo de errado aconteceu com o cadastro";
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
                      }
                      elseif (isset ($cadastro_error)) {
                          
                      echo "<div class='w3-container w3-center w3-red'>";
                      echo $cadastro_error;
                      echo "</div>";
                  }
                ?>
                
                <h2 style="text-align:center">Cadastro Usuário</h2>
                <form class="w3-container" action="cadastro_usuario.php" method="post">
                    <div class="w3-section">
                        <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Login" name="login" required>
                        <select class="w3-select w3-border w3-margin-bottom" name="tipo" required>
                            <option value="" disabled selected>Escolha o nivel de acesso</option>
                            <option value="1">Adminnistrador</option>
                            <option value="2">Operador (consultas e empréstimo)</option>
                            <option value="3">Standard (consultas)</option>
                        </select>
                        <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Senha" name="senha"  required>
                        
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
