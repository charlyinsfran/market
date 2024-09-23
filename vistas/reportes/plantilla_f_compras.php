<?php

require '../fpdf/fpdf.php';
$usuario = $_SESSION['usuario'];

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        global $tituloReporte;
        date_default_timezone_set('America/Asuncion');
        $fecha = date('d-m-Y H:i:s');
        // Logo
       $this->Image("../../imagenes/reportes/orden.png", 10, 5, 13);

        // Arial bold 15
        $this->SetFont("Arial", "U", 12);
        $this->SetTextColor(1,76,91);

        // Título
        $tituloReporte = "CONTROL DE INGRESO DE MERCADERIAS";
        $this->Cell(25);
        $this->Cell(140, 5,  mb_convert_encoding($tituloReporte, 'ISO-8859-1', 'UTF-8'), 0, 0, "C");

        //Fecha
        $this->SetFont("Times", "", 7);
        $this->Cell(25, 5, "Reporte: " . $fecha, 0, 1, "C");

        

        // Salto de línea
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Times', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'L');
        $this->Cell(-200, 10, 'Generado por: ' . strtoupper($_SESSION['usuario']), 0, 0, 'C');
        $this->Cell(0, 10, utf8_decode('Powered by: DCHR_SOFTWARE ©'), 0, 0, 'R');
    }
}

?>