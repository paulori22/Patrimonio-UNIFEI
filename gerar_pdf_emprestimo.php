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

    // Margins
    var $left = 10;
    var $right = 10;
    var $top = 10;
    var $bottom = 10;

    // Create Table
    function WriteTable($tcolums) {
        // go through all colums
        for ($i = 0; $i < sizeof($tcolums); $i++) {
            $current_col = $tcolums[$i];
            $height = 0;

            // get max height of current col
            $nb = 0;
            for ($b = 0; $b < sizeof($current_col); $b++) {
                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $nb = max($nb, $this->NbLines($current_col[$b]['width'], $current_col[$b]['text']));
                $height = $current_col[$b]['height'];
            }
            $h = $height * $nb;


            // Issue a page break first if needed
            $this->CheckPageBreak($h);

            // Draw the cells of the row
            for ($b = 0; $b < sizeof($current_col); $b++) {
                $w = $current_col[$b]['width'];
                $a = $current_col[$b]['align'];

                // Save the current position
                $x = $this->GetX();
                $y = $this->GetY();

                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);


                // Draw Cell Background
                $this->Rect($x, $y, $w, $h, 'FD');

                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);

                // Draw Cell Border
                if (substr_count($current_col[$b]['linearea'], "T") > 0) {
                    $this->Line($x, $y, $x + $w, $y);
                }

                if (substr_count($current_col[$b]['linearea'], "B") > 0) {
                    $this->Line($x, $y + $h, $x + $w, $y + $h);
                }

                if (substr_count($current_col[$b]['linearea'], "L") > 0) {
                    $this->Line($x, $y, $x, $y + $h);
                }

                if (substr_count($current_col[$b]['linearea'], "R") > 0) {
                    $this->Line($x + $w, $y, $x + $w, $y + $h);
                }


                // Print the text
                $this->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);

                // Put the position to the right of the cell
                $this->SetXY($x + $w, $y);
            }

            // Go to the next line
            $this->Ln($h);
        }
    }

    // If the height h would cause an overflow, add a new page immediately
    function CheckPageBreak($h) {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    // Computes the number of lines a MultiCell of width w will take
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    // Simple table
    function BasicTable($header, $data) {
        $autowidthtable = ($this->GetPageWidth() - $this->GetPageMarginL() - $this->GetPageMarginR()) / count($header);
        // Header
        $this->SetFont('', 'B');
        foreach ($header as $col)
            $this->MultiCell($autowidthtable, 7, $col, 1);
        $this->Ln();

        // Data
        $this->SetFont('');
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->MultiCell($autowidthtable, 6, $col, 1);
            $this->Ln();
        }
    }

    function contrato_emprestimo($nome_requisitante, $nome_usuario, $ra, $lab, $nome_coordenador_lab, $resultado, $data_termo, $observacao) {

        $texto = utf8_decode('Eu,'
                . ' ' . $nome_requisitante . ','
                . ' siape nº'
                . ' ' . $ra . '.'
                . ' Declaro ter recebido do Laboratório de'
                . ' ' . $lab
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

        $header_antigo = array(utf8_decode('Nº Serie'), utf8_decode('Descrição do Material'), 'Quantidade');
        $autowidthtable = ($this->GetPageWidth() - $this->GetPageMarginL() - $this->GetPageMarginR()) / count($header_antigo);

        //$this->BasicTable($header, $itens_patrimonio);

        $header = array();
        $header[] = array('text' => utf8_decode('Nº Serie'), 'width' => $autowidthtable, 'height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '12', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
        $header[] = array('text' => utf8_decode('Descrição do Material'), 'width' => $autowidthtable + + $autowidthtable*0.5, 'height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '12', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
        $header[] = array('text' => 'Quantidade', 'width' => $autowidthtable*0.5, 'height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '12', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
        $dados_tabela[] = $header;

        $dados_itens = null;
        while ($row = $resultado->fetch_assoc()) {

            $dados_itens = array();

            $dados_itens[] = array('text' => $row['numero_serie'], 'width' => $autowidthtable, 'height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '12', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
            $dados_itens[] = array('text' => $row['descricao_fabricante_modelo'], 'width' => $autowidthtable + $autowidthtable*0.5, 'height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '12', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
            $dados_itens[] = array('text' => 1, 'width' => $autowidthtable*0.5, 'height' => '5', 'align' => 'C', 'font_name' => 'Times', 'font_size' => '12', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');

            $dados_tabela[] = $dados_itens;
            
            //$dados_itens[] = array($row['numero_serie'], $row['descricao_fabricante_modelo'], 1);
        }

        $this->WriteTable($dados_tabela);
        if(!empty($observacao)){
            $this->MultiCell(0, 6, $observacao, 1);
        }
        $this->Ln(8);


        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, "ASSINATURA DOS RESPONSAVEIS", 1, 0, 'C');
        $this->SetFont('Times', '', 12);
        $this->Ln(8);
        $nome_coordenador = "Nome do Coordenador";
        $coordenador_lab = "Coordenador do Laboratório:                                                                                                        " . $data_termo . "\n"
                . "                      ___________________________________________________________________\n"
                . "                                                                      " . $nome_coordenador_lab . "                                      ";

        $this->MultiCell(0, 6, utf8_decode($coordenador_lab), 1);

        $nome_tecnico = $nome_usuario;
        $tecnico_lab = "Técnico Laboratório:                                                                                                                     " . $data_termo . "\n"
                . "                      ___________________________________________________________________\n"
                . "                                                                      " . $nome_tecnico . "                                      ";

        $this->MultiCell(0, 6, utf8_decode($tecnico_lab), 1);

        $nome_professor_ta = $nome_requisitante;
        $professor_ta = "Professor/Tecnico Administrativo:                                                                                               " . $data_termo . "\n"
                . "                      ___________________________________________________________________\n"
                . "                                                                      " . $nome_professor_ta . "                                      ";




        $this->MultiCell(0, 6, utf8_decode($professor_ta), 1);

        $this->Ln(8);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(0, 6, utf8_decode("DEVOLUÇÃO DO MATERIAL"), 1, 0, 'C');
        $this->SetFont('Times', '', 12);
        $this->Ln(8);
        $this->MultiCell(0, 6, utf8_decode("Atesto que o material foi conferido e devolvido dentro do prazo"
                        . " e nas mesmas condições em que foram emprestados.\n"
                        . "Assinatura:__________________________________________________________________"), 1);
        $this->Output();
    }

}

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $nome_usuario = $_GET['nome_usuario'];
    $nome = $_GET['nome'];
    $ra = $_GET['ra'];
    $data_emprestimo = $_GET['data_emprestimo'];
    $responsavel = $_GET['responsavel'];
    $laboratorio = $_GET['laboratorio'];
    $observacao = $_GET['obs'];

    $sql_consulta = "SELECT emprestimo_itens.id_emprestimo,patrimonio.numero_serie,patrimonio.descricao_fabricante_modelo "
            . "FROM `emprestimo_itens` "
            . "JOIN patrimonio ON `id_item`=patrimonio.id "
            . "WHERE `id_emprestimo` =$id ";

    $resultado = $conn->query($sql_consulta);
    if ($resultado->num_rows > 0) {

        $pdf = new PDF();
        $pdf->contrato_emprestimo($nome, $nome_usuario, $ra, $laboratorio, $responsavel, $resultado, $data_emprestimo,$observacao);
    }
}
?>