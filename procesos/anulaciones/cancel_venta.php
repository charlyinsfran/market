<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Operaciones.php";

$facturanro = $_POST['nrofactura'];
$usuario = $_SESSION['usuario'];
$codanulacion = $_POST['codanulacion'];


$datos = array($facturanro,$usuario,$codanulacion);

$obj = new operacion();
echo $obj->anularventa($datos);

?>