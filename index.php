<!DOCTYPE html>

<html>
    <title>Controle de Patrimonio ECO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <body>
        <?php
        session_start();
        $_SESSION["login"] = NULL;
        $_SESSION["senha"] = NULL;
        ?>
        <header class="w3-container w3-indigo">
            <h1>Controle de Patrimonio ECO</h1>
        </header>

        <div class="w3-container w3-cell-middle" style="width:30%;margin-right:auto;margin-left:auto;">

            <?php
                if (!empty($_GET['erro_login'])) {
                    echo '<div class="w3-container w3-red">' . $_GET['erro_login'] . "</div>";
                }
            ?>
            <form class="w3-container w3-card-4" action="pagina_inicial.php" method="POST">

                <p>
                    <input class="w3-input" type="text" name="login" style="width:90%" required>
                    <label class="w3-label w3-validate" style="color:black">Login</label></p>
                <p>
                    <input class="w3-input" type="password" name="senha" style="width:90%" required>
                    <label class="w3-label w3-validate" style="color:black">Senha</label></p>

                <p>
                    <button class="w3-btn w3-section w3-ripple" style="background-color:#dbe0e2"> Entrar </button></p>

            </form>

        </div>

    </body>
</html> 
