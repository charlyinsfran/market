

<?php

session_start();

	if(isset($_SESSION['usuario'])){ 

			if ($_POST['desde'] != "" AND $_POST['hasta'] != "") {


				$DESDE = $_POST['desde'];
				$HASTA = $_POST['hasta'];

			}
			else
			{
				header("location:../reportesdate.php?error=3");

			}
		
            require "../../clases/Conexion.php";
            require "plantilla_filtros.php";
		$c = new conectar();
		$conexion = $c->conexion();
		$query = "SELECT  v.fecha,CONCAT(c.nombre, ' ', c.apellido),u.usuario,v.total,v.subtotal,v.condicion
        from ventas v 
        JOIN clientes c on v.idcliente = c.idclientes 
        JOIN usuarios u 
		JOIN detalle_ventas dv on dv.venta_nro = v.idventas 
		 WHERE v.fecha >= '$DESDE' and v.fecha <= '$HASTA' group by v.total";
		$result = mysqli_query($conexion,$query);

		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage(); 
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFillColor(232,232,232);
		$pdf->Cell(20,6,'Fecha',1,0,'C',1);
		$pdf->Cell(50,6,'Cliente',1,0,'C',1);
		$pdf->Cell(20,6,'Cajero',1,0,'C',1);
		$pdf->Cell(30,6,'Total',1,0,'C',1);
        $pdf->Cell(30,6,'Subtotal',1,0,'C',1);
		$pdf->Cell(30,6,'Condicion',1,1,'C',1);




		$pdf->SetFont('Arial','',8);
		$ventas = 0;
		while ($ver = mysqli_fetch_row($result)) {
			
			
			
            $originalDate = $ver[0];
            $newDate = date("d-m-Y", strtotime($originalDate));
            
                    $pdf->Cell(20, 5, $newDate, 1, 0, "C");
                    $pdf->Cell(50, 5, $ver[1], 1, 0, "C");
                    $pdf->Cell(20, 5, strtoupper($ver[2]), 1, 0, "C");
                    $pdf->Cell(30, 5, 'Gs. ' . number_format($ver[3], 0, ",", "."), 1, 0, "C");
                    $pdf->Cell(30, 5, 'Gs. ' . number_format($ver[4], 0, ",", "."), 1, 0, "C");

                    $pdf->Cell(30, 5, strtoupper($ver[5]), 1, 1, "C");
					$ventas += $ver[4];
					
                }
				

		$pdf->Ln(10);
		$pdf->Cell(20,5,'Total Ventas Filtradas: '.'Gs. ' . number_format($ventas, 0, ",", "."),0,0,'');
		$pdf->Output('I', $tituloReporte . '.pdf');

	}
	else{
        header("location:../index.php");} ?>