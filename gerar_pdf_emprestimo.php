<?php

require 'fpdf181/fpdf.php';
require 'include/conexaoBD.php';

class PDF extends FPDF {

// Page header
    function Header() {
        $this->Cell(20, 20);
        // Logo
        $this->Image('include/logo_unifei.jpg', 10, 6, 15);
        // Arial bold 15
        $this->SetFont('Times', 'B', 12);
        // Move to the right
        $title = utf8_decode("UNIVERSIDADE FEDERAL DE ITAJUBÁ - CAMPUS ITABIRA LABORATÓRIOS DE ENGENHARIA DE COMPUTAÇÃO");
        // Title
        //$this->Cell(0,10,$title,1,0,'C');
        $this->MultiCell(0, 6, $title);
        // Line break
        $this->Ln(10);
        $this->SetFont('Times', 'B', 16);

        $this->Cell(0, 0, "TERMO DE RESPONSABILIDADE", 0, 1, 'C');
        $this->Ln(10);
    }

    // Simple table
    function BasicTable($header, $data) {
        $autowidthtable = ($this->GetPageWidth() - $this->GetPageMarginL() - $this->GetPageMarginR()) / count($header);
        // Header
        $this->SetFont('', 'B');
        foreach ($header as $col)
            $this->Cell($autowidthtable, 7, $col, 1);
        $this->Ln();

        // Data
        $this->SetFont('');
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell($autowidthtable, 6, $col, 1);
            $this->Ln();
        }
    }

    function contrato_emprestimo($nome, $ra, $lab, $itens_patrimonio,$data_termo) {

        $texto = utf8_decode('Eu,'
                . ' '.$nome.','
                . ' siape nº'
                . ' '.$ra.'.'
                . ' Declaro ter recebido do Laboratório de'
                . ' '.$lab
                . ' da UNIFEI o bem abaixo relacionado com titulo de empréstimo,'
                . ' para execução das atividades acadêmicas. O material permanecerá sob a minha responsabilidade no qual devo devolvê-los dentro do prazo estipulado. Devo zelar pelo material enquanto estiver em meu uso. O mesmo será conferido ao ser entregue.');

        // Instanciation of inherited class
        $this->AliasNbPages();
        $this->AddPage();

        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, "RETIRADA DO MATERIAL", 1, 0, 'C');
        $this->Ln(8);

        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 6, $texto, 1);

        $header = array(utf8_decode('Nº Serie'), utf8_decode('Descrição do Material'), 'Quantidade');

        $this->BasicTable($header, $itens_patrimonio);
        $this->Ln(8);


        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, "ASSINATURA DOS RESPONSAVEIS", 1, 0, 'C');
        $this->SetFont('Times', '', 12);
        $this->Ln(8);
        $this->MultiCell(0, 6, utf8_decode("Coordenador do Laboratório:                                                                                                        " . $data_termo), 1);
        $this->MultiCell(0, 6, utf8_decode("Técnico Laboratório:                                                                                                                     " . $data_termo), 1);
        $this->MultiCell(0, 6, utf8_decode("Professor/Tecnico Administrativo:                                                                                               " . $data_termo), 1);

        
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, utf8_decode("DEVOLUÇÃO DO MATERIAL"), 1, 0, 'C');
        $this->SetFont('Times', '', 12);
        $this->Ln(8);
        $this->MultiCell(0, 6, utf8_decode("Atesto que o material foi conferido e devolvido dentro do prazo"
                        . " e nas mesmas condições em que me foram emprestados.\n"
                        . "Assinatura:__________________________________________________________________"), 1);
        $this->Output();
    }

}

if (isset($_GET['id'])) {
    
    $id = $_GET['id'];
    $nome = $_GET['nome'];
    $ra = $_GET['ra'];
    $data_emprestimo = $_GET['data_emprestimo'];
    
    $sql_consulta = "SELECT emprestimo_itens.id_emprestimo,patrimonio.numero_serie,patrimonio.descricao_fabricante_modelo FROM `emprestimo_itens` JOIN patrimonio ON `id_item`=patrimonio.id WHERE `id_emprestimo` =$id ";
    $resultado = $conn->query($sql_consulta);
    if ($resultado->num_rows > 0) {
       // output data of each row
       $dados_itens = null;
       while($row = $resultado->fetch_assoc()) {
           
           $dados_itens[] = array($row['numero_serie'], $row['descricao_fabricante_modelo'], 1);
        

       }
       $pdf = new PDF();
       $pdf->contrato_emprestimo($nome, $ra, "Computação", $dados_itens,$data_emprestimo);
    }
    
}

?>