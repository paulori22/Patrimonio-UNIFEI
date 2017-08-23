<?php

        $id = $_SESSION["id_usuario"];
        $senha = $_SESSION["senha"];
        $servername = "localhost";
        $username = "root";
        $password = "lab2208";
        $dbname = "controle_lab_eco_bd";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

?>