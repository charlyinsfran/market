<?php 
session_start();
error_reporting(0);
if(isset($_SESSION['usuario'])){ 

	?>

	<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Reportes</title>
		<link rel="shorcut icon" href="../imagenes/dinero.png" type="image/png">
		<?php require_once "menu.php";?> 
		

	
		
	</head>
	<body>
		<div class="container">
			<div class="col-md-2"></div>
			<div class="col-md-6">
				<div class="row">
					<div class="panel panel-success">
						<div class="panel panel-heading" style="text-align: center;"><strong>Reports View</strong></div>	
						<div class="panel panel-body">

						<form action="">
							<div class="col-sm-12">
		
							<span class="btn btn-primary glyphicon" name="ventas" id="ventas" style="width: 150px; height: 60px;">
                            <label style="font-family: sans-serif; font-weight:bold;font-size:20px;"><p></p>VENTAS</label>
                        </span>

						<span class="btn btn-success glyphicon" name="compras" id="compras" style="width: 150px; height: 60px;">
                            <label style="font-family: sans-serif; font-weight:bold;font-size:20px;"><p></p>COMPRAS</label>
                        </span>
			
							</div>
						</form>
						<br>
						</div>
						
						<div class="row">
							<div class="col-sm-12">
								<div id="filtros"></div>
								<br>
								<div id=""></div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</body>
	</html>
	<script>
		$(document).ready(function(){
			
			$('#ventas').click(function(){
				$('#filtros').load("reportes/busquedas/view_ventas.php");

			});

			$('#compras').click(function(){
				$('#filtros').load("reportes/busquedas/view_compras.php");

			});
			

		});


	</script>
	
	<?php
	switch ($_GET['error']) {
		case 1:
		echo '<script language="Javascript">
		alertify.alert("Opcion Inválida");
		</script>';

		break;  
		case 2:
		echo '<script language="Javascript">
		alertify.alert("Sin resultados");
		</script>';

		break; 

		case 3:
			echo '<script language="Javascript">
			alertify.alert("Debe seleccionar un rango de filtrado");
			</script>';
	
			break; 
	}
}
else{
	header("location:../index.php");} ?>