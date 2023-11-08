<?php
session_start();
$usuario = $_SESSION['iduser'];

require_once "../../clases/Conexion.php";
require_once "../../clases/Stock.php";

date_default_timezone_set('America/Asuncion');
$fecha = date('Y-m-d H:i:s');

$datos = array($_POST['idproducto'],$_POST['stocknuevo'],$usuario,$fecha,$_POST['cantidad']);

$obj= new stock();

echo $obj->actualizarstock($datos);
	

	
	


?>