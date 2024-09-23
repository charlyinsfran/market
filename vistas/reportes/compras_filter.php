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
            require "plantilla_f_compras.php";
		$c = new conectar();
		$conexion = $c->conexion();
		$query = "SELECT  c.idcompras,c.fecha,p.razon_social,LEFT(pro.nombre,20),dc.cantidad,c.total,c.condicion,u.usuario
        from compras c 
        JOIN proveedores p on p.idproveedores = c.idproveedores
        JOIN usuarios u
        join detalle_compra dc on dc.compra_nro = c.idcompras
        join productos pro on pro.id_producto = dc.id_producto 
		WHERE c.fecha >= '$DESDE' and c.fecha <= '$HASTA' group BY c.total";
		$result = mysqli_query($conexion,$query);

		$pdf = new PDF();
		$pdf->AliasNbPages();
		$pdf->AddPage(); 
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(8);
		$pdf->SetFillColor(232,232,232);
		$pdf->Cell(20,6,utf8_decode('N° Compra'),1,0,'C',1);
		$pdf->Cell(20,6,'Fecha',1,0,'C',1);
		$pdf->Cell(30,6,'Proveedor',1,0,'C',1);
		$pdf->Cell(32,6,'Producto',1,0,'L',1);
        $pdf->Cell(16,6,'Cantidad',1,0,'C',1);
		$pdf->Cell(20,6,'Total',1,0,'C',1);
		$pdf->Cell(20,6,'Condicion',1,0,'C',1);
		$pdf->Cell(15,6,'Usuario',1,1,'C',1);
		





		$pdf->SetFont('Arial','',6);
		$compras = 0;
		while ($ver = mysqli_fetch_row($result)) {

            $originalDate = $ver[1];
            $newDate = date("d-m-Y", strtotime($originalDate));
					$pdf->Cell(8);
                    $pdf->Cell(20, 5, $ver[0], 1, 0, "C");
                    $pdf->Cell(20, 5, $newDate, 1, 0, "C");
                    $pdf->Cell(30, 5, $ver[2], 1, 0, "C");
                    $pdf->Cell(32, 5, $ver[3], 1, 0, "L");
                    $pdf->Cell(16, 5, $ver[4], 1, 0, "C");
                    $pdf->Cell(20, 5, 'Gs. ' . number_format($ver[5], 0, ",", "."), 1, 0, "C");
					$pdf->Cell(20, 5, strtoupper($ver[6]), 1, 0, "C");
					$pdf->Cell(15, 5, strtoupper($ver[7]), 1, 1, "L");
					$compras+=$ver[5];
					
            
                }
				$pdf->Ln(10);
				$pdf->Cell(20,5,'Total Ventas Filtradas: '.'Gs. ' . number_format($compras, 0, ",", "."),0,0,'');
				$pdf->Output('I', $tituloReporte . '.pdf');

	}
	else{
        header("location:../index.php");} ?>