<?php

require "../clases/Conexion.php";
require "reportes/plantilla.php";




    $c = new conectar();
    $conexion = $c->conexion();

    $sql = "SELECT  v.fecha,CONCAT(c.nombre, ' ', c.apellido),u.usuario,v.total,v.subtotal,v.condicion
    from ventas v 
    JOIN clientes c on v.idcliente = c.idclientes 
    JOIN usuarios u group by v.idventas;";
    $resultado = mysqli_query($conexion,$sql);


    $tituloReporte = "Ventas Report View";

    $pdf = new PDF("P", "mm", "letter");
    $pdf->SetTitle($tituloReporte);
    $pdf->SetAuthor('DCHR_SOFTWARE ©');
    $pdf->AliasNbPages();
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    $pdf->SetFont("Arial", "B", 9);

    $pdf->Cell(20, 5, "Fecha", 1, 0, "C");
    $pdf->Cell(50, 5, "Cliente", 1, 0, "C");
    $pdf->Cell(20, 5, "Cajero", 1, 0, "C");
    $pdf->Cell(30, 5, "Total Venta", 1, 0, "C");
    $pdf->Cell(30, 5, "SubTotal", 1, 0, "C");
    $pdf->Cell(30, 5, "Condicion", 1, 1, "C");

    $pdf->SetFont("Arial", "", 8);

    while ($ver = mysqli_fetch_row($resultado)) {

$originalDate = $ver[0];
$newDate = date("d-m-Y", strtotime($originalDate));

        $pdf->Cell(20, 5, $newDate, 1, 0, "C");
        $pdf->Cell(50, 5, $ver[1], 1, 0, "C");
        $pdf->Cell(20, 5, strtoupper($ver[2]), 1, 0, "C");
        $pdf->Cell(30, 5, 'Gs. ' . number_format($ver[3], 0, ",", "."), 1, 0, "C");
        $pdf->Cell(30, 5, 'Gs. ' . number_format($ver[4], 0, ",", "."), 1, 0, "C");
        $pdf->Cell(30, 5, strtoupper($ver[5]), 1, 1, "C");

    }

    $pdf->Output('I', $tituloReporte . '.pdf');


?>