<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Caja.php";

$monto =$_POST['montocierre'];
$fechacierre = $_POST['fechacierre'];
$diferencia = $_POST['diferencia'];
$codigo = $_POST['codigo'];


$datos = array($monto,$fechacierre,$diferencia,$codigo);

$obj = new caja();

echo $obj->cierrecaja($datos);


?>