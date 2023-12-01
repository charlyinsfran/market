<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Caja.php";

$monto =$_POST['montototal'];
$usuario = $_SESSION['iduser'];
$fecha = $_POST['fecha'];


$datos = array($monto,$fecha,$usuario);

$obj = new caja();

echo $obj->aperturacaja($datos);


?>