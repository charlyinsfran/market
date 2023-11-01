<?php

require_once "../../clases/Conexion.php";
require_once "../../clases/Productos.php";



$datos = array($_POST['idproducto'],$_POST['categoria_selectupdate'],$_POST['descripcionupdate'],$_POST['detalleupdate'],
$_POST['precioupdate'],$_POST['iva_selectupdate']);

$obj= new productos();

echo $obj->actualizarproductos($datos);
	
	
	
	


?>