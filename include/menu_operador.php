
<nav class="w3-sidebar w3-collapse w3-bar-block w3-light-grey w3-card-2" style="width:250px" id="menu_lateral">
    <h2 class="w3-center">Menu</h2>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-indigo w3-hide-large w3-closenav w3-large">Fechar <i class="fa fa-remove"></i></a>
    <a href="emprestimo.php" class="w3-bar-item w3-button"><b>Emprestimo</b></a>
    <a href="devolucao.php" class="w3-bar-item w3-button"><b>Devolução</b></a>
    <div class="w3-light-grey w3-medium w3-bar-item w3-button" onclick="OpenSubMenu4()">
        <b>Termo de Responsabilidade</b> <i class="fa fa-caret-down"></i>
    </div>
    <div id="sub_menu_4" class="w3-hide w3-white w3-card-4">
        <a href="termo_responsabilidade.php" class="w3-bar-item w3-button">Gerar termo</a>
        <a href="termo_upload.php" class="w3-bar-item w3-button">Upload do termo</a>
    </div>
    <div class="w3-light-grey w3-medium w3-bar-item w3-button" onclick="OpenSubMenu1()">
        <b>Itens</b> <i class="fa fa-caret-down"></i>
    </div>
    <div id="sub_menu_1" class="w3-hide w3-white w3-card-4">
        <a href="busca_consumo.php" class="w3-bar-item w3-button">Busca Consumo</a>
        <a href="busca_permanente.php" class="w3-bar-item w3-button">Busca Permanente</a>
    </div>
    <a href="index.php" class="w3-bar-item w3-button"><b>Sair</b></a>
</nav>


<script>
    
    function w3_open() {
        document.getElementById("menu_lateral").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
    }

    function w3_close() {
        document.getElementById("menu_lateral").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
    }

    function OpenSubMenu1() {
        var x = document.getElementById("sub_menu_1");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            x.previousElementSibling.className += " w3-gray";
        } else {
            x.className = x.className.replace(" w3-show", "");
            x.previousElementSibling.className =
                    x.previousElementSibling.className.replace(" w3-gray", "");
        }
    }
        function OpenSubMenu4() {
        var x = document.getElementById("sub_menu_4");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            x.previousElementSibling.className += " w3-gray";
        } else {
            x.className = x.className.replace(" w3-show", "");
            x.previousElementSibling.className =
                    x.previousElementSibling.className.replace(" w3-gray", "");
        }
    }




</script>